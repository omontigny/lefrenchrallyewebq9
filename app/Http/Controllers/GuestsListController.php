<?php

namespace App\Http\Controllers;

use App\Models\Parent_Group;
use App\Models\Invitation;
use App\Models\Venue;
use App\Models\Parent_Event;
use App\Models\Parents;
use App\Models\Rallye;
use App\Models\Parent_Rallye;
use App\Models\CheckIn;
use App\Models\Group;
use App\Models\Children;
use App\Models\Application;
use App\Models\KeyValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Repositories\EmailRepository;
use App\Repositories\ImageRepository;
use Intervention\Image\Facades\Image;
use Exception;

class GuestsListController extends Controller
{
  protected $emailRepository;
  protected $imageRepository;

  public function __construct(EmailRepository $emailRepository, ImageRepository $imageRepository)
  {
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
      // Get connected parent
      $parent = Parents::where('user_id', Auth::user()->id)->first();

      // Get Active Rallye
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();


      // To manage error message
      $found = false;

      // At least one active rallye is found
      if ($parentRallye != null) {
        // Get parent's evented application of the active rallye
        $applications = Application::where('parent_id', $parent->id)
          ->where('rallye_id', $parentRallye->rallye->id)
          ->where('evented', 1)->get();

        // Get the first application
        $application = $applications->first();

        // Case when the parent has one application
        if (count($applications) == 1) {

          $found = true;

          $applications  = Application::where('rallye_id', $application->rallye_id)->where('event_id', $application->event_id)->get();

          $groupsID = collect();
          foreach ($applications as $application) {
            $groupsID[] = $application->event_id;
          }

          $data = Invitation::where('rallye_id', $parentRallye->rallye->id)->get();

          $groups = Group::all();
          $groupsID = $groupsID->unique();
          $datas = [
            'application' => $application,
            'groups' => $groups,
            'data' => $data,
            'groupsID' => $groupsID,
            'applications' => $applications
          ];

          return view('guestLists.index')->with($datas);
        } else if (count($applications) > 1) {
          $found = true;
          return redirect('/parentChildren');
        } else {
          $found = false;
        }
      }

      if (!$found) {
        return Redirect::back()->withError('E077: You do not belong to any event group for the active rallye.');
      }
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
    //
    if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      $parent = Parents::where('user_id', Auth::user()->id)->first();
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
      $invitation = Invitation::find($id);

      if ($parentRallye->rallye->id == $invitation->rallye->id) {
        $checkins = null;

        $extracheckins =
          DB::table('guests')
          ->JOIN('rallyes', 'rallyes.id', '=', 'guests.rallye_id')
          ->JOIN('children', 'children.id', '=', 'guests.invitedby_id')
          ->JOIN('groups', 'groups.id', '=', 'guests.group_id')

          ->select(
            'guests.id',
            'guests.guestfirstname',
            'guests.guestlastname',
            'groups.eventDate',
            'guests.nb_invitations',
            'guests.guestemail'
          )

          ->where('guests.rallye_id', '=', $invitation->rallye_id)
          ->where('guests.group_id', '=', $invitation->group->id)
          ->get();


        if ($invitation->rallye->isPetitRallye) {
          $checkins = DB::table('applications')
            ->JOIN('rallyes', 'rallyes.id', '=', 'applications.rallye_id')
            ->JOIN('children', 'children.application_id', '=', 'applications.id')
            ->JOIN('checkins', 'checkins.child_id', '=', 'children.id')
            ->JOIN('invitations', 'invitations.id', '=', 'checkins.invitation_id')
            ->JOIN('groups', 'groups.id', '=', 'checkins.group_id')

            ->select(
              'checkins.id',
              'applications.childfirstname',
              'applications.childlastname',
              'groups.eventDate',
              'invitations.venue_address',
              'invitations.theme_dress_code',
              'invitations.start_time',
              'invitations.end_time',
              'checkins.checkStatus',
              'applications.parentemail'
            )

            ->where('invitations.id', '=', $invitation->id)
            ->where('applications.rallye_id', '=', $invitation->rallye_id)
            ->where('checkins.group_id', '=', $invitation->group->id)
            ->where('applications.group_name', '=', Str::upper($invitation->group->name))

            ->get();
        } else {
          $checkins = DB::table('applications')
            ->JOIN('rallyes', 'rallyes.id', '=', 'applications.rallye_id')
            ->JOIN('children', 'children.application_id', '=', 'applications.id')
            ->JOIN('checkins', 'checkins.child_id', '=', 'children.id')
            ->JOIN('invitations', 'invitations.id', '=', 'checkins.invitation_id')
            ->JOIN('groups', 'groups.id', '=', 'checkins.group_id')

            ->select(
              'checkins.id',
              'applications.childfirstname',
              'applications.childlastname',
              'groups.eventDate',
              'invitations.venue_address',
              'invitations.theme_dress_code',
              'invitations.start_time',
              'invitations.end_time',
              'checkins.checkStatus',
              'applications.parentemail'
            )

            ->where('invitations.id', '=', $invitation->id)
            ->where('applications.rallye_id', '=', $invitation->rallye_id)
            ->where('checkins.group_id', '=', $invitation->group->id)
            ->get();
        }

        $data = [
          'checkins' => $checkins,
          'extracheckins' => $extracheckins,
          'invitation' => $invitation
        ];

        return view('checkin.index')->with($data);
      }
    } else {
      return Redirect::back()->withError('E078: you do not take part of check in team for the active rallye.');
    }
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  public function reminderInvitationMail($id)
  {
    if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      $parent = Parents::where('user_id', Auth::user()->id)->first();
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
      $invitation = Invitation::find($id);

      if ($parentRallye->rallye->id == $invitation->rallye->id) {
        $checkins = null;
        if ($invitation->rallye->isPetitRallye) {
          $checkins = DB::table('applications')
            ->JOIN('rallyes', 'rallyes.id', '=', 'applications.rallye_id')
            ->JOIN('children', 'children.application_id', '=', 'applications.id')
            ->JOIN('checkins', 'checkins.child_id', '=', 'children.id')
            ->JOIN('invitations', 'invitations.id', '=', 'checkins.invitation_id')
            ->JOIN('groups', 'groups.id', '=', 'checkins.group_id')

            ->select(
              'checkins.id',
              'applications.childfirstname',
              'applications.childlastname',
              'groups.eventDate',
              'invitations.venue_address',
              'invitations.theme_dress_code',
              'invitations.start_time',
              'invitations.end_time',
              'checkins.checkStatus',
              'applications.parentemail',
              'rallyes.rallyemail'
            )

            ->where('invitations.id', '=', $invitation->id)
            ->where('applications.rallye_id', '=', $invitation->rallye_id)
            ->where('checkins.group_id', '=', $invitation->group->id)
            ->where('applications.group_name', '=', Str::upper($invitation->group->name))
            ->where('checkins.checkStatus', '=', 0)
            ->get();
        } else {
          $checkins = DB::table('applications')
            ->JOIN('rallyes', 'rallyes.id', '=', 'applications.rallye_id')
            ->JOIN('children', 'children.application_id', '=', 'applications.id')
            ->JOIN('checkins', 'checkins.child_id', '=', 'children.id')
            ->JOIN('invitations', 'invitations.id', '=', 'checkins.invitation_id')
            ->JOIN('groups', 'groups.id', '=', 'checkins.group_id')

            ->select(
              'checkins.id',
              'applications.parentemail',
              'applications.childfirstname',
              'applications.childlastname',
              'groups.eventDate',
              'invitations.venue_address',
              'invitations.theme_dress_code',
              'invitations.start_time',
              'invitations.end_time',
              'checkins.checkStatus',
              'applications.parentfirstname',
              'rallyes.rallyemail'
            )

            ->where('invitations.id', '=', $invitation->id)
            ->where('applications.rallye_id', '=', $invitation->rallye_id)
            ->where('checkins.group_id', '=', $invitation->group->id)
            ->where('checkins.checkStatus', '=', 0)
            ->get();
        }

        $data = [
          'checkins' => $checkins,
          'invitation' => $invitation
        ];
        $rallye_name = $this->emailRepository->replaceNameForStoring(Rallye::find($invitation->rallye_id)->title);
        $group_name = "std";
        if (Rallye::find($invitation->rallye_id)->isPetitRallye) {
          $group_name = $this->emailRepository->replaceNameForStoring(Group::find($invitation->group_id)->name);
        }
        $imageInfo          = $this->imageRepository->setImageInfo($invitation, $rallye_name, $group_name);
        $cloudinaryImageUrl = $this->imageRepository->UploadFromImage64($invitation->invitationFile, $invitation->extension, $rallye_name, $group_name, $imageInfo["imagePath"], $imageInfo["imageMetadata"]);

        $imageUrl = URL::asset($imageInfo["imagePath"]);
        Log::stack(['single', 'stdout'])->debug("[REMINDER MAIL] - image_url: " . $imageUrl);
        Log::stack(['single', 'stdout'])->debug("[REMINDER MAIL] - cloudinary_image_url: " . $cloudinaryImageUrl);


        $domainLink = $this->emailRepository->getKeyValue('DOMAIN_LINK');

        // Sending the invitation to each parent/child
        foreach ($checkins as $checkin) {

          $htmlData = [
            'checkin'    => $checkin,
            'domainLink' => $domainLink,
            'rallye_name' => $rallye_name,
            'imageName'  => $imageInfo["imageName"],
            'invitationFile' => $invitation->invitationFile,
            'imageUrl' => $imageUrl,
            'cloudinaryImageUrl' => $cloudinaryImageUrl
          ];

          //////////////////////////////////////////////////////////////////////
          // MAIL 08: Reminder Invitation Email (SMTP)
          //////////////////////////////////////////////////////////////////////

          Mail::send('mails/reminderInvitationEmail', $htmlData, function ($m) use ($checkin) {
            $m->from($checkin->rallyemail, env('APP_NAME'));
            $m->replyTo($checkin->rallyemail);
            $m->to($checkin->parentemail);
            $m->subject('[' . env('APP_NAME') . '] - Reminder “reply to invitation”');
          });

          //////////////////////////////////////////////////////////////////////
          // MAIL 08: Reminder Invitation Email (MailGun)
          //////////////////////////////////////////////////////////////////////
          // $msgdata = array(
          //   'from'        => env('APP_NAME') . '<' . $checkin->rallyemail . '>',
          //   'subject'     => '[' . env('APP_NAME') . '] - Reminder “reply to invitation”',
          //   'to'          => $checkin->parentemail . " " . $checkin->parentemail . ' <' . $checkin->parentemail . '>',
          //   "h:Reply-To"  => $checkin->rallyemail,
          // );

          // $html = view('mails/reminderInvitationEmail', $htmlData)->render();
          // $this->emailRepository->sendMailGun($msgdata, $html);
          //////////////////////////////////////////////////////////////////////

          //Use CheckMailSent to log and check if sending OK
          $this->emailRepository->CheckMailSent($checkin->parentemail . " for " . $invitation->rallye->title, Mail::flushMacros(), "reminderInvitationEmail to", Auth::user()->name);
        }
        return Redirect::back()->with('success', 'M033: Reminder “reply to invitation” mails have been sent');
      }
    } else {
      return Redirect::back()->withError('E078: you do not take part of check in team for the active rallye.');
    }
  }
}
