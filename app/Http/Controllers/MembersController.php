<?php

namespace App\Http\Controllers;

use App\Models\Parent_Group;
use App\Models\Parent_Event;
use Illuminate\Http\Request;
use App\Models\Parents;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use App\Models\Coordinator_Rallye;
use App\Models\Coordinator;
use App\Models\Children;
use App\Models\Application;
use App\Models\Calendar;
use App\Models\Parent_Rallye;
use App\Models\Rallye;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;

class MembersController extends Controller
{

  // if user is not identified, he will be redirected to the login page
  public function __construct()
  {
    $this->middleware('auth');
  }
  /**

   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
  }

  public function invitations()
  {
    //
    //$rallyes = Rallye::all();
    //$rallyes = Rallye::orderBy('title', 'asc')->take(1)->get();
    //$rallyes = Rallye::orderBy('title', 'asc')->paginate(10);
    $rallyes = Rallye::oldest('title')->get();
    return view('members.invitations')->with('rallyes', $rallyes);
  }

  public function myRallye()
  {
    $data = null;
    $applications = [];
    $rallyesID = [];
    $bcclist = "";

    if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      $parent = Parents::where('user_id', Auth::user()->id)->first();
      if ($parent != null) {
        $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->get()->first();
        $rallye = $parentRallye;
        $applications = Application::where('rallye_id', $parentRallye->rallye->id)->where('status', '1')->get();
      }
    }

    // if it's a coordinator request.
    else if (Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {

      $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
      if ($coordinator != null) {
        $coordinatorRallyes = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
          ->where('active_rallye', '1')->get();

        $coordinatorRallye = $coordinatorRallyes->first();

        if ($coordinatorRallye != null) {
          $rallye_email = $coordinatorRallye->rallye->rallyemail;
          $rallye_title = $coordinatorRallye->rallye->title;
        }

        foreach ($coordinatorRallyes as $coordinatorRallye) {
          $rallyesID[] = $coordinatorRallye->rallye_id;
        }

        $applications = Application::wherein('rallye_id', $rallyesID)->where('status', '1')->get();
        $bcclist = $this->getListParentsMail($applications);
      }
    }

    if (count($applications) > 0) {

      $mailBodyPlacehodeler = $this->getMailbody($rallye_title);

      $results = [
        'applications' => $applications,
        'bcclist'      => $bcclist,
        'rallye_email' => $rallye_email,
        'rallye_title' => $rallye_title,
        'mail_body'    => $mailBodyPlacehodeler,
      ];

      return view('members.myrallye')->with($results);
    } else {
      return Redirect::back()->withError('E084:  You do not belong to any rallye/Or Rallye is empty');
    }
  }

  public function myGroup()
  {
    $applications = [];
    $rallyesID = [];

    if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      $parent = Parents::where('user_id', Auth::user()->id)->first();
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
      $found = false;
      if ($parentRallye != null) {
        $applications = Application::where('parent_id', $parent->id)
          ->where('rallye_id', $parentRallye->rallye->id)
          ->where('grouped', 1)->get();

        $application = $applications->first();

        if (count($applications) == 1) {
          $found = true;

          $applications  = Application::where('rallye_id', $application->rallye_id)->where('group_name', $application->group_name)->get();
          $bcclist = "";
          $applications = [
            'applications'  => $applications,
            'bcclist' => $bcclist
          ];

          return view('members.mygroup')->with($applications);
        } else if (count($applications) > 1) {
          $found = true;
          return redirect('/parentChildrenGroup');
        } else {
          $found = false;
        }
      }

      if (!$found) {
        return Redirect::back()->withError('E085: You do not belong to any group for the active rallye.');
      }
    }

    // if it's a coordinator request.
    else if (Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {

      $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
      if ($coordinator != null) {
        $coordinatorRallyes = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
          ->where('active_rallye', '1')->get();

        $coordinatorRallye = $coordinatorRallyes->first();

        if ($coordinatorRallye != null) {
          $rallye_email = $coordinatorRallye->rallye->rallyemail;
          $rallye_title = $coordinatorRallye->rallye->title;
        }

        foreach ($coordinatorRallyes as $coordinatorRallye) {
          $rallyesID[] = $coordinatorRallye->rallye_id;
        }

        $applications = Application::wherein('rallye_id', $rallyesID)
          ->where('status', '1')
          ->where('grouped', true)->get();
      }
    }

    if (count($applications) > 0) {

      $bcclist = $this->getListParentsMail($applications);
      $mailBodyPlacehodeler = $this->getMailbody($rallye_title);

      $results = [
        'applications' => $applications,
        'bcclist'      => $bcclist,
        'rallye_email' => $rallye_email,
        'rallye_title' => $rallye_title,
        'mail_body'    => $mailBodyPlacehodeler,
      ];

      return view('members.mygroup')->with($results);
    } else {
      return Redirect::back()->withError('E086: You do not belong to any group/Or the group is empty.');
    }
  }

  public function getListParentsMail($applications)
  {
    $bcclist = "";
    $compteur = 0;
    foreach ($applications as $row) {
      if ($compteur < (count($applications) - 1)) {
        $bcclist .= $row->parentemail . ",";
      } else {
        $bcclist .=  $row->parentemail;
      }
      $compteur++;
    }
    return $bcclist;
  }

  public function myEventGroup()
  {
    // Cases to manage:
    // Parent affected to one event group.
    // Parent affected to more than one event group

    // For SUPERADMIN and COORDINATOR
    // Access to event group by clicking or search group event from the groupEventManager

    $applications = [];
    $rallyesID    = [];

    if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      $parent = Parents::where('user_id', Auth::user()->id)->first();
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
      $found = false;
      if ($parentRallye != null) {
        $applications = Application::where('parent_id', $parent->id)
          ->where('rallye_id', $parentRallye->rallye->id)
          ->where('evented', 1)->get();

        $application = $applications->first();

        if (count($applications) == 1) {
          $found = true;

          $applications  = Application::where('rallye_id', $application->rallye_id)->where('event_id', $application->event_id)->get();

          $bcclist = "";

          $applications = [
            'applications'  => $applications,
            'bcclist' => $bcclist
          ];

          return view('members.myeventgroup')->with($applications);
        } else if (count($applications) > 1) {
          $found = true;
          return redirect('/parentChildren');
        } else {
          $found = false;
        }
      }

      if (!$found) {
        return Redirect::back()->withError('E087: You do not belong to any event group for the active rallye.');
      }
    }
    // if it's a coordinator request.

    else if (Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {

      $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
      if ($coordinator != null) {
        $coordinatorRallyes = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
          ->where('active_rallye', '1')->get();

        $coordinatorRallye = $coordinatorRallyes->first();

        if ($coordinatorRallye != null) {
          $rallye_email = $coordinatorRallye->rallye->rallyemail;
          $rallye_title = $coordinatorRallye->rallye->title;
        }

        foreach ($coordinatorRallyes as $coordinatorRallye) {
          $rallyesID[] = $coordinatorRallye->rallye_id;
        }

        $applications = Application::wherein('rallye_id', $rallyesID)
          ->where('status', '1')
          ->where('evented', '1')->get();
      }

      $mailBodyPlacehodeler = $this->getMailbody($rallye_title);

      $bcclist = $this->getListParentsMail($applications);
      $applications = [
        'applications'  => $applications,
        'bcclist' => $bcclist,
        'rallye_email' => $rallye_email,
        'rallye_title' => $rallye_title,
        'mail_body' => $mailBodyPlacehodeler,
      ];

      return view('members.myeventgroup')->with($applications);
    } else {
      return Redirect::back()->withError('E088: You do not belong to any rallye');
    }
  }

  public function myEvent()
  {

    //$rallyes = Rallye::all();
    //$rallyes = Rallye::orderBy('title', 'asc')->take(1)->get();
    $rallyes = Rallye::oldest('title')->paginate(10);
    //$rallyes = Rallye::orderBy('title', 'asc')->get();
    return view('members.myrallye')->with('rallyes', $rallyes);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
    $parents = Parents::where('has_event', false)
      ->oldest('parentlastname')
      ->oldest('parentfirstname')->get();
    $rallyes    = Rallye::oldest('title')->get();
    $calendars  = Calendar::oldest('calendar_date')->get();

    $data = [
      'rallyes'   => $rallyes,
      'parents'   => $parents,
      'calendars' => $calendars
    ];

    return view('parentEvents.create')->with($data);
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

  private function getMailbody($rallye_title)
  {
    $mailBodyPlacehodeler = "<p>Dear Parents</p>
       <p><font color=\"grey\">Enter Your email body here...</font></p>
       <br>
       <br>
       <br>
       ---------------
       <p>See you,</p>
       <p>The $rallye_title Coordinators</p>
       ";
    return $mailBodyPlacehodeler;
  }
}
