<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Models\Parent_Group;
use App\Models\Invitation;
use App\Models\Venue;
use App\Models\Parent_Event;
use App\Models\Parents;
use App\Models\Parent_Rallye;
use App\Models\CheckIn;
use App\Models\Group;
use App\Models\Children;
use App\Models\Application;
use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Carbon;

class MultiCheckinController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function attending($id, $invitation_id)
  {
    $this->setAttendingValue($id, 1);
    return redirect('/multicheckin/' . $invitation_id)->with('success', 'M034: Your confirmation has been saved successfully');
  }

  public function notattending($id, $invitation_id)
  {
    $this->setAttendingValue($id, 2);
    return redirect('/multicheckin/' . $invitation_id)->with('success', 'M035: The cancellation has been done successfully.');
  }

  public function setAttendingValue($id, $value)
  {
    //
    $checkIn = CheckIn::find($id);
    $checkIn->child_present = $value;
    $checkIn->save();
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

          $limitDate = Carbon::now()->sub(1, 'day');

          $invitations = Invitation::where('rallye_id', $parentRallye->rallye->id)->get();
          $invitations = Invitation::with('group')->where('rallye_id', $parentRallye->rallye->id)->get()->where('group.eventDate', '>=', $limitDate)->sortBy('group.eventDate', SORT_REGULAR, false);

          Log::stack(['stdout'])->debug("invitations: " . count($invitations));

          $groups = Group::all();
          $groupsID = $groupsID->unique();
          $data = [
            'application' => $application,
            'groups' => $groups,
            'invitations' => $invitations,
            'groupsID' => $groupsID,
            'applications' => $applications
          ];

          return view('multiCheckin.index')->with($data);
        } else if (count($applications) > 1) {
          Log::stack(['stdout'])->debug("nb _applications: " . count($applications));
          $found = true;
          return Redirect::back()->withError('E090: You have more than 1 application associated to you accound please choose one .');
          # make a page to selec which application to choose
          # return redirect('/multicheckin');
        } else {
          $found = false;
        }
      }

      if (!$found) {
        return Redirect::back()->withError('E089: You do not belong to any event group for the active rallye.');
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
    Log::stack(['stdout'])->debug('Je suis dans MulticheckinController:SHOW');

    if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      $parent       = Parents::where('user_id', Auth::user()->id)->first();
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
      $invitation   = Invitation::find($id);
      Log::stack(['stdout'])->debug("id: " . $id);

      Log::stack(['stdout'])->debug("parentRallye: " . $parentRallye->id);
      Log::stack(['stdout'])->debug("invitation: " . $invitation->id);

      if ($parentRallye->rallye->id == $invitation->rallye->id) {

        try {

          $parent = Parents::where('user_id', Auth::user()->id)->get()->first();

          if ($parent != null) {
            $applicationEvent = Application::where('parent_id', $parent->id)->first();

            if ($applicationEvent != null) {
              $guestList = DB::table('applications')
                ->join('children', 'children.application_id', '=', 'applications.id')
                ->join('checkins', 'checkins.child_id', '=', 'children.id')
                ->join('invitations', 'invitations.id', '=', 'checkins.invitation_id')
                ->select(
                  'checkins.id',
                  'applications.childfirstname',
                  'applications.childlastname',
                  'applications.parentfirstname',
                  'applications.parentlastname',
                  'applications.parentmobile',
                  'checkins.child_present',
                  'checkins.checkStatus',
                  'applications.childphotopath'
                )
                //->where('parents.user_id', '=', Auth::user()->id)
                ->where('invitations.id', '=', $id)
                ->where('checkins.checkStatus', '!=', 2)
                ->where('checkins.checkStatus', '!=', 0)
                ->orderby('applications.childlastname', 'ASC')
                ->get();

              Log::stack(['stdout'])->debug("nb results pour invit {{$id}} : " . count($guestList));

              $missingChildren = DB::table('applications')
                ->join('children', 'children.application_id', '=', 'applications.id')
                ->join('checkins', 'checkins.child_id', '=', 'children.id')
                ->join('invitations', 'invitations.id', '=', 'checkins.invitation_id')
                ->select(
                  'checkins.id',
                  'applications.childfirstname',
                  'applications.parentfirstname',
                  'applications.parentmobile',
                  'checkins.child_present',
                  'checkins.checkStatus',
                )
                ->where('invitations.id', '=', $id)
                ->where('checkins.checkStatus', '!=', 2)
                ->where('checkins.checkStatus', '!=', 0)
                ->where('checkins.child_present', '=', 0)

                ->get();

              $extraguestList =
                DB::table('guests')
                ->JOIN('rallyes', 'rallyes.id', '=', 'guests.rallye_id')
                ->JOIN('children', 'children.id', '=', 'guests.invitedby_id')
                ->JOIN('parents', 'parents.id', '=', 'children.parent_id')
                ->JOIN('groups', 'groups.id', '=', 'guests.group_id')


                ->select(
                  'guests.id',
                  'guests.guestfirstname',
                  'guests.guestlastname',
                  'parents.parentfirstname',
                  'parents.parentlastname',
                  'parents.parentmobile',
                  'groups.eventDate',
                  'guests.nb_invitations',
                  'guests.guestemail',
                  'guests.guestmobile'

                )

                ->where('guests.rallye_id', '=', $invitation->rallye_id)
                ->where('guests.group_id', '=', $invitation->group->id)
                ->get();
            } else {
              return Redirect::back()->withError('E090: You do not belong to any event');
            }
          } else {
            return Redirect::back()->withError('E091: You do not have the parent profile.');
          }

          $missingChildrenList = [];
          foreach ($guestList as $row) {
            if ($row->child_present == 0) {
              array_push($missingChildrenList, $row->parentmobile);
            }
          }
          $missingChildrenList = implode(',', $missingChildrenList);

          # $SMSBodyPlacehodeler = $this->getDefaultSMSbody();
          $data = [
            'guestList'        => $guestList,
            'extraguestList'    => $extraguestList,
            'missingChildren'   => $missingChildren,
            'invitation_id'     => $invitation->id,
            'missingChildrenList' => $missingChildrenList,
            # 'SMSBodyPlacehodeler' => $SMSBodyPlacehodeler
          ];

          sleep(3);

          Log::stack(['stdout'])->debug("juste avant go view: ");

          return view('checkinEvent.index')->with($data);
        } catch (Exception $e) {
          return Redirect::back()->withError('E092: ' . $e->getMessage());
        }
      }
    } else {
      return Redirect::back()->withError('E093: you do not take part of check in team for the active rallye.');
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id, $invitation_id)
  {
    $checkin = CheckIn::find($id);
    $child = Children::where('id', $checkin->child_id)->first();
    $application = Application::where('id', $child->application_id)->first();
    $datas = [
      'checkin' => $checkin,
      'application' => $application,
      'invitation_id' => $invitation_id
    ];

    return view('checkinEvent.edit')->with($datas);
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

  public function sendSMSMissingChildren(Request $request, $id)
  {
    try {
      $smsBody = $request->input('smsBody');
      $subject = $request->input('subject');
      $body    = $subject . "\n" . strip_tags($smsBody);
      $missingChildren = json_decode($request->missingChildren, true);
      $invitation  = Invitation::find($request->input('invitation_id'));

      // Your Account SID and Auth Token from twilio.com/console
      $sid   = env('TWILIO_SID');
      $token = env('TWILIO_TOKEN');
      $phone = env('TWILIO_PHONE');

      $parent = Parents::where('user_id', Auth::user()->id)->get()->first();;

      foreach ($missingChildren  as $row) {
        $recipient = $row['parentmobile'];
        $body = $this->getSMSbody($row['parentfirstname'], $row['childfirstname'], $invitation->theme_dress_code, $invitation->group->eventDate, $parent->parentmobile);

        $client = new Client($sid, $token);
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
          // the number you'd like to send the message to
          $recipient,
          [
            // A Twilio phone number you purchased at twilio.com/console
            'from' => $phone,
            // the body of the text message you'd like to send
            'body' => $body
          ]
        );
      };

      return redirect('multicheckin/' . $id)->with('success', 'S001: Parents will receive a SMS to alert children missing');
    } catch (Exception $e) {
      Log::stack(['stdout', 'stdout'])->debug("[EXCEPTION] - [CHECKIN] : sendSMSMissingChildren to parents : ça passe  pas !" .  $e->getMessage());
      return Redirect::back()->withError('E198: ' . $e->getMessage());
    }
  }

  private function getDefaultSMSbody()
  {
    // $mailBodyPlacehodeler = "<p>Dear [ParentName]</p>
    //    <p> Your child [xx] is attending to the party [Theme] on [date].</p>
    //    <p> He/she is not present yet. Is everything ok ?
    //    <br>
    //    <br>
    //    ---------------
    //    <p>See you,</p>
    //    <p>The Parent Coordinators ([Coordinator PhoneNumber])</p>
    //    ";

    $mailBodyPlacehodeler = "Dear [ParentName]
       Your child [xx] is attending to the party [Theme] on [date].
       He/she is not present yet. Is everything ok ?

       ---------------
       See you,
       The Parent Coordinator ([Coordinator PhoneNumber])
       ";
    return $mailBodyPlacehodeler;
  }

  private function getSMSbody($parentName, $childName, $themeDressCode, $eventDate, $coordinatorPhoneNumber)
  {

    $mailBodyPlacehodeler = "Dear {$parentName}
       Your child {$childName} is attending to the party {$themeDressCode} on {$eventDate}.
       He/she is not present yet. Is everything ok ?

       ---------------
       See you,
       The Parent Coordinator ({$coordinatorPhoneNumber})
       ";
    return $mailBodyPlacehodeler;
  }
}
