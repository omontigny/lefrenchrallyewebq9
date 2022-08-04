<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Parent_Group;
use App\Models\Invitation;
use App\Models\Venue;
use App\Models\Parent_Event;
use App\Models\Parents;
use App\Models\Parent_Rallye;
use App\Models\CheckIn;
use App\Models\Group;
use App\Models\Rallye;
use App\Models\Children;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use App\Repositories\ImageRepository;
use App\Repositories\EmailRepository;
use Exception;
use Illuminate\Support\Carbon;


# Imports the Google Cloud client library
use Google\Cloud\Storage\StorageClient;

class InvitationsController extends Controller
{
  protected $imageRepository;

  public function __construct(EmailRepository $emailRepository, ImageRepository $imageRepository)
  {
    // if user is not identified, he will be redirected to the login page
    $this->middleware('auth');
    $this->emailRepository = $emailRepository;
    $this->imageRepository = $imageRepository;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      $parent = Parents::where('user_id', Auth::user()->id)->first();
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
      $found = false;
      if ($parentRallye != null) {
        # on verifie que le parent est bien assigné à un group (evented) et on récupere son application
        $applications = Application::where('parent_id', $parent->id)
          ->where('rallye_id', $parentRallye->rallye->id)
          ->where('evented', 1)->get();

        $application = $applications->first();

        if (count($applications) == 1) {
          $found = true;

          # liste des applications ayant le meme event_id (group_id)
          $applications  = Application::where('rallye_id', $application->rallye_id)->where('event_id', $application->event_id)->get();

          $applicationGroupIds = collect();
          # liste des groupes concernés (cas d'enfants dans différents groups)
          foreach ($applications as $application) {
            $applicationGroupIds[] = $application->event_id;
          }

          $limitDate = Carbon::now()->sub(1, 'day');

          $invitations = Invitation::with('group')->where('rallye_id', $parentRallye->rallye->id)->with('user')->get()->where('group.eventDate', '>=', $limitDate)->sortBy('group.eventDate', SORT_REGULAR, false);
          $oldInvitations = Invitation::with('group')->where('rallye_id', $parentRallye->rallye->id)->get()->where('group.eventDate', '<', $limitDate)->sortBy('group.eventDate', SORT_REGULAR, false);

          $groups = Group::oldest('eventDate')->get();
          $applicationGroupIds = $applicationGroupIds->unique();

          /* existe t'il deja une invitation pour ce rallye et ce group  */
          $availableGroupIds = [];
          if ($invitations->where('group_id', $application->event_id)->count() == 0) {
            $availableGroupIds = $applicationGroupIds;
          }

          $data = [
            'application' => $application,
            'groups' => $groups,
            'invitations' => $invitations,
            'oldInvitations' => $oldInvitations,
            'groupsID' => $applicationGroupIds,
            'availableGroupIds' => $availableGroupIds,
            'applications' => $applications
          ];

          return view('invitations.index')->with($data);
        } else if (count($applications) > 1) {
          $found = true;
          return redirect('/parentChildren');
        } else {
          $found = false;
        }
      }

      if (!$found) {
        return Redirect::back()->withError('E079: You do not belong to any event group for the active rallye.');
      }
    } else {
      return Redirect::back()->withError('E187: This section is reserved to parent only those affected to event group.');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
    $this->validate($request, [
      //Rules to validate
      'calendar_id' => 'required',
      'venue_address' => 'required',
      'theme_dress_code' => 'required',
      'start_time' => 'required',
      'end_time' => 'required'

    ]);

    try {
      DB::beginTransaction();
      $parent = Parents::where('user_id', Auth::user()->id)->first();
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
      $group = Group::find($request->input('calendar_id'));
      $invitation = Invitation::where('theme_dress_code', Str::upper($request->input('theme_dress_code')))
        ->where('rallye_id', $parentRallye->rallye->id)
        ->where('group_id', $group->id)
        ->first();

      if ($invitation == null) {
        // Add an invitation
        $invitation = new Invitation();
        $invitation->group_id = $request->input('calendar_id');
        $invitation->venue_address = $request->input('venue_address');
        $invitation->user_id = Auth::user()->id;
        $invitation->theme_dress_code = Str::upper($request->input('theme_dress_code'));
        $invitation->start_time = Str::upper($request->input('start_time'));
        $invitation->end_time = Str::upper($request->input('end_time'));
        $invitation->rallye_id = Group::find($invitation->group_id)->rallye_id;
        $rallye_name = $this->emailRepository->replaceNameForStoring(Rallye::find($invitation->rallye_id)->title);
        // Log::stack(['stdout'])->debug('Rallye Name: ' . $rallye_name);
        Log::stack(['single', 'stdout'])->debug('fichier uploadé: ' . $_FILES["invitationFile"]["name"]);
        $target_filename = basename($_FILES["invitationFile"]["name"]);
        Log::stack(['single', 'stdout'])->debug('target_filename: ' . $target_filename);

        $invitationTempFolder = 'images/invitations/' . $rallye_name;
        if (!Storage::disk('temp')->exists($invitationTempFolder)) {
          Storage::disk('temp')->makeDirectory($invitationTempFolder, 0777, true, true);
        };
        $temp_dir = Storage::disk('temp')->path($invitationTempFolder); #storage/app/temp/images/invitations/$rallye_name
        Log::stack(['single', 'stdout'])->debug('temp_dir: ' . $temp_dir);

        $temp_file = $temp_dir . Str::random(10) . "_" . $target_filename;
        Log::stack(['single', 'stdout'])->debug('full path temp file: ' . $temp_file);

        // Select file type
        $imageFileType = Str::lower(pathinfo($temp_file, PATHINFO_EXTENSION));
        Log::stack(['single', 'stdout'])->debug('imageFileType:' . $imageFileType);

        // Valid file extensions
        $extensions_arr = ["png", "jpg", "jpeg"];

        // Check extension
        if (in_array($imageFileType, $extensions_arr)) {
          // // Convert to base64
          // $image_base64 = base64_encode(file_get_contents($_FILES['invitationFile']['tmp_name']));

          /**  Convert to base64 and resize picture **/
          $source_file = $_FILES['invitationFile']['tmp_name'];
          // Log::stack(['single', 'stdout'])->debug("source file: " . $source_file);

          // We do resize only if filesize > 300Ko
          if (filesize($source_file) > 307200) {
            Log::stack(['single', 'stdout'])->info("***** We have to resize this picture *********");
            $orientation = @exif_read_data($source_file)['Orientation']; // @ for silent warning exif_read_data(php3KLADx): File not supported for some png files
            Log::stack(['single', 'stdout'])->debug("exif orientation : $orientation");

            // resize image with a max value for width or height fixed to 500
            $this->imageRepository->resizeImage(
              $source_file,
              $temp_file,
              $imageFileType,
              850
            );
            // sometimes some pictures change orientation after resizing, that's why next step restoring correction orentation
            $rotatedFile = $this->imageRepository->rotateImageByExifOrientation($temp_file, $imageFileType, $orientation);
            if (is_resource($rotatedFile)) {
              imagejpeg($rotatedFile, $temp_file, 100);
            }
            Log::stack(['single', 'stdout'])->info("***** End Resize image *********");
          } else {
            $temp_file = $_FILES["invitationFile"]["tmp_name"];
          }

          // get base64 encoding of the new file to store in database
          $image_base64 = base64_encode(file_get_contents($temp_file, true));
          $image = 'data:image/' . $imageFileType . ';base64,' . $image_base64;
          // copy file into public folder for link

          // delete local tempory file
          if (!unlink($temp_file)) {
            Log::stack(['single', 'stdout'])->error("$temp_file cannot be deleted due to an error");
          } else {
            Log::stack(['single', 'stdout'])->info("$temp_file has been correctly deleted");
          }
          /** end convert with resize **/

          $invitation->invitationFile = $image;
          $invitation->extension      = $imageFileType;
        } else {
          return Redirect::back()->withError('250: Only .png, jpg, jpeg extensions that are accepted.');
        }

        $invitation->save();

        $group = Group::find($request->input('calendar_id'));

        if ($invitation->rallye->isPetitRallye) {
          $applications = Application::where('rallye_id', $invitation->rallye_id)
            ->where('group_name', $invitation->group->name)
            ->get();
          foreach ($applications as $application) {
            $child = Children::where('application_id', $application->id)->first();
            $checkin = new CheckIn();
            $checkin->invitation_id = $invitation->id;
            $checkin->group_id = $group->id;
            $checkin->rallye_id = $group->rallye->id;
            $checkin->child_id = $child->id;
            $checkin->checkStatus = false;
            $checkin->save();
          }
        } else {
          $children = Children::where('rallye_id', $invitation->rallye_id)->get();
          if (count($children) > 0) {
            foreach ($children as $child) {
              $checkin = new CheckIn();
              $checkin->invitation_id = $invitation->id;
              $checkin->group_id = $group->id;
              $checkin->rallye_id = $group->rallye->id;
              $checkin->child_id = $child->id;
              $checkin->checkStatus = false;
              $checkin->save();
            }
          }
        }

        DB::commit();
        return Redirect::back()->with('success', 'M030: The invitation has been added successfully');
      } else {
        DB::rollback();
        return redirect('/invitations')->withErrors('E011: There is already an invitation with the same theme  ' . Str::upper($request->input('theme_dress_code')) . ' for this group');
      }
    } catch (Exception $e) {
      DB::rollback();
      return Redirect::back()->withError('E080: ' . $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
    Log::stack(['single', 'stdout'])->debug('>>>> DANS LA SHOW de Invitation Controller');

    $application = Application::find($id);
    $applications = Application::where('rallye_id', $application->rallye_id)->where('event_id', $application->event_id)->get();

    $applicationGroupIds = collect();
    foreach ($applications as $application) {
      $applicationGroupIds[] = $application->event_id;
    }

    $data = Invitation::all();

    $groups = Group::all();
    $applicationGroupIds = $applicationGroupIds->unique();
    $datas = [
      'application' => $application,
      'groups' => $groups,
      'data' => $data,
      'applicationGroupIds' => $applicationGroupIds,
      'applications' => $applications
    ];

    return view('invitations.index')->with($datas);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
    Log::stack(['single', 'stdout'])->debug('Je suis dans InvitationControlle:EDIT - empty Method');
    return redirect('/parentChildren');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    try {
      //$id = $request->input('invitation_id');
      $invitation = Invitation::find($id);
      if ($invitation  != null) {
        $invitation->venue_address = $request->input('venue_address');
        $invitation->theme_dress_code = $request->input('theme_dress_code');
        $invitation->start_time = $request->input('start_time');
        $invitation->end_time = $request->input('end_time');
        $invitation->save();

        return redirect('/invitations')->with('success', 'M050: Invitation has been updated successfully!');
      } else {
        return Redirect::back()->withError('E115: No invitation found');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E116: ' . $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      //
      $deleted = false;
      $errorMsg = '';
      DB::beginTransaction();
      $invitation = Invitation::where('id', $id)
        ->where('user_id', Auth::user()->id)->get()->first();

      if ($invitation != null) {
        // The current user is the invitation owner
        //$invitation->checkins()->delete();
        $invitation->delete();
        $rallye_name = $this->emailRepository->replaceNameForStoring(Rallye::find($invitation->rallye_id)->title);
        $group_name = "std";
        if (Rallye::find($invitation->rallye_id)->isPetitRallye) {
          $group_name = $this->emailRepository->replaceNameForStoring(Group::find($invitation->group_id)->name);
        }
        $imageInfo  = $this->imageRepository->setImageInfo($invitation, $rallye_name, $group_name);
        $this->imageRepository->destroyImage64($rallye_name, $imageInfo["imagePath"], $imageInfo["imageMetadata"]);

        $deleted = true;
      } else {
        $errorMsg = "E300: you are not owner, you can't delete, please contact your admin.";
      }
      if ($deleted) {
        DB::commit();
        return redirect('/invitations')->with('success', 'M007: invitation deleted');
      } else {
        DB::rollback();
        return Redirect::back()->withError($errorMsg);
      }
    } catch (Exception $e) {
      DB::rollback();
      return Redirect::back()->withError('E039: ' . $e->getMessage());
    }
  }
}
