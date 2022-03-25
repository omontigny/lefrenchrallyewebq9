<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use Exception;
use Carbon\Carbon;
use App\Models\Coordinator;
use App\Models\Coordinator_Rallye;
use App\Models\Admin_Rallye;
use App\Models\Rallye;
use App\Models\Children;
use App\Models\Application;
use App\Models\School;
use App\Models\Schoolyear;
use App\Models\Parents;
use App\Models\Parent_Rallye;
use App\Models\Role_User;
use App\Models\Invitation;
use App\Models\CheckIn;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Repositories\EmailRepository;
use App\Repositories\ImageRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class ApplicationRequestsPrivateController extends Controller
{
  protected $emailRepository;
  protected $imageRepository;

  public function __construct(EmailRepository $emailRepository, ImageRepository $imageRepository)
  {
    // if user is not identified, he will be redirected to the login page
    $this->middleware('auth');
    $this->emailRepository = $emailRepository;
    $this->imageRepository = $imageRepository;
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    try {

      //
      $application = Application::find($id);
      $rallyes = Rallye::orderBy('title', 'asc')->get();
      $schools = School::orderBy('name', 'asc')->get();
      $schoolyears = Schoolyear::orderBy('id', 'asc')->get();
      $userDebug = $application->parentemail;
      $data = [
        'application' => $application,
        'rallyes'   => $rallyes,
        'schools'   => $schools,
        'schoolyears'   => $schoolyears,
        'userDebug' => $userDebug
      ];

      return view('applicationrequests.edit')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E037: ' . $e->getMessage());
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function editChildPhoto($id)
  {
    $application = Application::find($id);
    $data = [
      'application' => $application
    ];

    return view('applicationrequests.editchildphoto')->with($data);
  }
  public function updateChildPicture(Request $request)
  {
    try {
      if ($request->has('childphotopath')) {
        $application = Application::find($request->input('applicationID'));

        // Valid file extensions
        $extensions_arr = [
          "png", "jpg", "jpeg"
        ];
        $target_file = basename($_FILES["childphotopath"]["name"]);
        // Select file type
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check extension
        if (in_array($imageFileType, $extensions_arr)) {

          /**  Convert to base64 and resize picture **/
          $source_file = $_FILES['childphotopath']['tmp_name'];
          Log::stack(['single', 'stdout'])->debug("source file: " . $source_file);
          // Log::stack(['single', 'stdout'])->debug(realpath('.') . PHP_EOL);
          // Log::stack(['single', 'stdout'])->debug("file: " . $source_file);

          //$image_base64 = base64_encode(file_get_contents($source_file));

          // We do resize only if filesize > 150Ko
          if (filesize($source_file) > 152400) {
            Log::stack(['single', 'stdout'])->info("***** We have to resize this picture *********");

            $destination_dir = Storage::disk('temp')->getAdapter()->getPathPrefix() . "images/childphoto/";
            if (!File::isDirectory($destination_dir)) {
              File::makeDirectory($destination_dir, 0777, true, true);
            };
            $destination_file = $destination_dir . $application->id . '_' . $target_file;

            $orientation = @exif_read_data($source_file)['Orientation']; // @ for silent warning exif_read_data(php3KLADx): File not supported for some png files
            Log::stack(['single', 'stdout'])->debug("exif orientation : $orientation");

            // resize image with a max value for width or height fixed to 500
            $this->imageRepository->resizeImage(
              $source_file,
              $destination_file,
              $imageFileType,
              500
            );
            // sometimes some pictures change orientation after resizing, that's why next step restoring correction orentation
            $rotatedFile = $this->imageRepository->rotateImageByExifOrientation($destination_file, $imageFileType, $orientation);
            if (is_resource($rotatedFile)) {
              imagejpeg($rotatedFile, $destination_file, 100);
            }
            Log::stack(['single', 'stdout'])->info("***** End Resize image *********");
          } else {
            $destination_file = $_FILES["childphotopath"]["tmp_name"];
          }

          // get base64 encoding of the new file to store in database
          $image_base64 = base64_encode(file_get_contents($destination_file, true));
          $image = 'data:image/' . $imageFileType . ';base64,' . $image_base64;

          // this is big debug info, so log it only on debug Mode
          // if (env('APP_DEBUG')) {
          //   Log::stack(['single'])->info("new image in base64: $image");
          // }

          // delete local tempory file
          if (!unlink($destination_file)) {
            Log::stack(['single', 'stdout'])->error("$destination_file cannot be deleted due to an error");
          } else {
            Log::stack(['single', 'stdout'])->info("$destination_file has correctly been deleted");
          }


          /**  Convert to base64 without resize picture **/
          // $image_base64 = base64_encode(file_get_contents($_FILES['childphotopath']['tmp_name']));
          // $image = 'data:image/' . $imageFileType . ';base64,' . $image_base64;

          $application->childphotopath = $image;
          $application->extension = $imageFileType;
          $application->save();
          return redirect('/applicationrequests')->with('success', 'M600: The picture has been successfully uploaded.');
        } else {
          return Redirect::back()->withError('E255: Only .png, jpg, jpeg extensions that are accepted.');
        }
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E600: ' . $e->getMessage());
    }
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
      // Creating an application
      $application = Application::find($id);
      $isTransferred = false;
      // rallye info

      if ($request->has('rallye_id') && $application->rallye_id != $request->input('rallye_id')) {
        $isTransferred = true;
        if ($application->status == 1 || $application->previous_status == 1) {
          $child = Children::where('application_id', $application->id)->first();

          // Check if there is any invitation (checkIn) for this child in his old Rallye to delete them
          $checkIns = CheckIn::where('rallye_id', $application->rallye_id)->where('child_id', $child->id)->get();

          foreach ($checkIns as $checkIn) {
            $childCheckIn = CheckIn::find($checkIn->id);
            $childCheckIn->delete();
          }

          $application->rallye_id = $request->input('rallye_id');

          $application->grouped = 0;
          $application->previous_group_status = 0;
          $application->group_id = null;
          $application->group_name = '';

          // To delete event date
          $application->evented = 0;
          $application->event_id = null;

          $application->save();

          $child->group_id = null;
          $child->affected = false;
          $child->rallye_id = $request->input('rallye_id');
          $child->save();

          if (!$application->rallye->isPetitRallye) {
            // Check if there is any events for the choosen rallye and adding child to their checkin lists
            $invitations = Invitation::where('rallye_id', $child->rallye_id)->get();
            if (count($invitations) > 0) {
              foreach ($invitations as $invitation) {
                // creating checkin for all invitations
                if ($invitation->group->rallye->id == $application->rallye_id) {
                  $checkin = new CheckIn();
                  $checkin->invitation_id = $invitation->id;
                  $checkin->group_id = $invitation->group->id;
                  $checkin->rallye_id = $invitation->group->rallye->id;
                  $checkin->child_id = $child->id;
                  $checkin->checkStatus = false;
                  $checkin->save();
                }
              }
            }
          }

          $parent = Parents::find($child->parent_id);
          $parent->affected = false;
          $parent->save();

          // Parent Rallye
          $parentRallyeDB = Parent_Rallye::where('parent_id', $parent->id)->where('application_id', $application->id)->first();
          $parentRallyeDB->rallye_id = $application->rallye_id;
          $parentRallyeDB->save();
        } else if (
          $application->status == 0 || $application->previous_status == 0
        ) {
          $application->rallye_id = $request->input('rallye_id');
        }
      }


      $application->is_boarder = ($request->has('is_boarder')) ? true : false;

      // child info
      $application->childfirstname    = ($request->has('childfirstname')) ? ucwords(strtolower($request->input('childfirstname'))) : $application->childfirstname;
      $application->childlastname     = ($request->has('childlastname')) ? $request->input('childlastname') : $application->childlastname;
      $application->childbirthdate    = ($request->has('childbirthdate')) ? Carbon::createFromFormat('d/m/Y', $request->input('childbirthdate'))->format('Y-m-d') : $application->childbirthdate;
      $application->childgender       = ($request->has('childgender')) ? $request->input('childgender') : $application->childgender;
      $application->childemail        = ($request->has('childemail')) ? $request->input('childemail') : $application->childemail;
      $application->simblingList      = ($request->has('simblingList')) ? $request->input('simblingList') : $application->simblingList;
      if ($request->has('hasinsurancecover')) {
        $application->hasinsurancecover = true;
      }

      // parent info

      $application->parentfirstname  = ($request->has('parentfirstname')) ? ucwords(strtolower($request->input('parentfirstname'))) : $application->parentfirstname;
      $application->parentlastname   = ($request->has('parentlastname')) ? $request->input('parentlastname') : $application->parentlastname;
      $application->parentaddress    = ($request->has('parentaddress')) ? $request->input('parentaddress') : $application->parentaddress;
      $application->parenthomephone  = ($request->has('parenthomephone')) ? $request->input('parenthomephone') : $application->parenthomephone;
      $application->parentmobile     = ($request->has('parentmobile')) ? $request->input('parentmobile') : $application->parentmobile;

      if ($request->has('parentemail') && $application->parentemail != $request->input('parentemail')) {
        $user = User::where('email', strtolower($application->parentemail))->first();
        if ($user != null) {
          $application->parentemail = $request->input('parentemail');
          $user->email = $application->parentemail;
          $user->save();
        }
      }
      $application->school_id     = ($request->has('school_id')) ? $request->input('school_id') : $application->school_id;

      if ($request->has('schoolState')) {
        $school = School::find($application->school_id);
        $school->state = strtoupper($request->input('schoolState'));
        $school->save();
        $application->schoolstate = strtoupper($request->input('schoolState'));
      }

      $application->schoolyear_id     = ($request->has('schoolyear_id')) ? $request->input('schoolyear_id') : $application->schoolyear_id;
      $application->preferredmember1 = ($request->has('preferredmember1')) ? $request->input('preferredmember1') : $application->preferredmember1;
      $application->preferredmember2 = ($request->has('preferredmember2')) ? $request->input('preferredmember2') : $application->preferredmember2;

      $application->preferreddate1 = ($request->has('preferreddate1')) ? Carbon::createFromFormat('d/m/Y', $request->input('preferreddate1'))->format('Y-m-d') : $application->preferreddate1;
      $application->preferreddate2 = ($request->has('preferreddate2')) ? Carbon::createFromFormat('d/m/Y', $request->input('preferreddate2'))->format('Y-m-d') : $application->preferreddate2;

      $application->save();

      /* This email is de-activated following the meeting with Cylia and Valerie on 24/09/2021 */
      // if ($isTransferred) {
      //   // Your child is transferred from one rallye to another one
      //   //////////////////////////////////////////////////////////////////////
      //   // MAIL 12: Transfered Email (SMTP)
      //   //////////////////////////////////////////////////////////////////////
      //   $data = array('application' => $application);

      //   Mail::send('mails/transferredEmail', $data, function ($m) use ($application) {
      //     $m->from($application->rallye->rallyemail, env('APP_NAME'));
      //     $m->replyTo($application->rallye->rallyemail);
      //     $m->to($application->parentemail);
      //     $m->subject('[' . env('APP_NAME') . '] - Your child is transferred from one rallye to another one');
      //   });
      //  // Use CheckMailSent to log and check if sending OK
      //  $this->emailRepository->CheckMailSent($application->childfirstname . " " . $application->childlastname, Mail::failures(), "applicationReceived", "Guest");
      //////////////////////////////////////////////////////////////////////
      //}

      return redirect('/applicationrequests')->with('success', 'M005: application Info updated');
    } catch (Exception $e) {
      //var_dump($e->errorInfo);
      return Redirect::back()->withError('E038: ' . $e->getMessage());
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
      $application = Application::find($id);
      if ($application != null) {
        $applications = Application::where('parent_id', $application->parent_id)->get();
        $countApplications = count($applications);

        // The parent has one application
        $parent = Parents::where('id', $application->parent_id)->first();
        if ($parent != null) {
          $user = User::find($parent->user_id);
          if ($user != null) {
            $child = Children::where('application_id', $application->id)->first();
            if ($child != null) {
              CheckIn::where('child_id', $child->id)->delete();
              $child->delete();
              Parent_Rallye::where(
                'parent_id',
                $parent->id
              )
                ->where('application_id', $application->id)->delete();
              $application->parent_id = null;
              $application->save();

              if ($countApplications == 1) {
                $parentRole = Role::where('rolename', config('constants.roles.PARENT'))->first();
                Role_User::where('user_id', $user->id)
                  ->where('role_id', $parentRole->id)->delete();
                $parent->delete();
              }

              if (count(Role_User::where('user_id', $user->id)->get()) == 0) {
                $user->delete();
              }

              $application->delete();
              $deleted = true;
            } else {
              $errorMsg = 'E252: child not found, please contact your admin.';
            }
          } else {
            $errorMsg = 'E253: user not found, please contact your admin.';
          }
        } else {
          // The application is approved yet.
          $application->delete();
          $deleted = true;
        }
      } else {
        $errorMsg = 'E254: Application not found, please contact your admin.';
      }

      if ($deleted) {
        DB::commit();
        return redirect('/applicationrequests')->with('success', 'M006: application deleted');
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
