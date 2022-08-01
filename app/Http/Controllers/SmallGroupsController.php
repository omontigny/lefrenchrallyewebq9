<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Rallye;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Coordinator;
use App\Models\Coordinator_Rallye;
use App\Models\Application;
use App\Models\Invitation;
use App\Models\Admin_Rallye;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Repositories\EmailRepository;

class SmallGroupsController extends Controller
{

  protected $emailRepository;

  public function __construct(EmailRepository $emailRepository)
  {
    // if user is not identified, he will be redirected to the login page
    $this->middleware('auth');
    $this->emailRepository = $emailRepository;
  }

  public function getDateInMySQLFormat($eventDate)
  {
    return Carbon::createFromFormat('d/m/Y', $eventDate)->format('Y-m-d');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      $rallye_id = '';
      if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
        $adminRallye = Admin_Rallye::where('user_id', Auth::user()->id)
          ->where('active_rallye', '1')->first();

        if ($adminRallye != null) {
          $rallye_id = $adminRallye->rallye->id;
          $rallye = Rallye::find($rallye_id);
          if (!$rallye->isPetitRallye) {
            return Redirect::back()->withError('E237: The active rallye is not (Smallone).');
          }
        }
      } elseif (Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {

        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
        if ($coordinator != null) {
          $coordinatorRallye = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
            ->where('active_rallye', '1')->get()->first();
          if ($coordinatorRallye != null) {
            $rallye_id = $coordinatorRallye->rallye->id;
            $rallye = Rallye::find($rallye_id);
            if (!$rallye->isPetitRallye) {
              return Redirect::back()->withError('E237: The active rallye is not (Smallone).');
            }
            //
          } else {
            return Redirect::back()->withError('E231: Please select your active rallye');
          }
        } else {
          return Redirect::back()->withError('E232: Your coordinator profile has to be verified, please contact your admin.');
        }
      }

      if ($rallye_id != '') {
        $groups = Group::where('rallye_id', $rallye_id)
          ->orderBy('name', 'asc')->paginate(100);
        return view('smallGroups.index')->with('groups', $groups);
      } else {
        return Redirect::back()->withError('E233: This section is for administor/Coordinator only - Check your active rallye');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E166: ' . $e->getMessage());
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    try {

      $rallye_id = '';
      if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
        $adminRallye = Admin_Rallye::where('user_id', Auth::user()->id)
          ->where('active_rallye', '1')->first();

        if ($adminRallye != null) {
          $rallye_id = $adminRallye->rallye->id;
        }
      } elseif (Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {

        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
        if ($coordinator != null) {
          $coordinatorRallye = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
            ->where('active_rallye', '1')->get()->first();
          if ($coordinatorRallye != null) {
            $rallye_id = $coordinatorRallye->rallye->id;
            //
          } else {
            return Redirect::back()->withError('E234: Please select your active rallye');
          }
        } else {
          return Redirect::back()->withError('E235: Your coordinator profile has to be verified, please contact your admin.');
        }
      }

      if ($rallye_id != '') {
        // only (Petit Rallye)
        $rallyes = Rallye::where('id', $rallye_id)
          ->where('isPetitRallye', '1')->orderBy('title', 'asc')->get();
        $data = [
          'rallyes'  => $rallyes
        ];

        return view('smallGroups.create')->with($data);
      } else {
        return Redirect::back()->withError('E236: This section is for administor/Coordinator only.');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E167: ' . $e->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {

      $this->validate($request, [
        //Rules to validate
        'rallye_id' => 'required',
        'eventDate' => 'required'
      ]);

      // Check if there is already a grouyp with the same eventDate for the same rallye
      $rallye = Rallye::find($request->input('rallye_id'));
      if ($rallye != null) {
        $groups = Group::all();
        foreach ($groups as $group) {
          if (
            $group->rallye_id != $rallye->id
            && strtoupper($group->name) == strtoupper($request->input('name'))
          ) {
            return back()->withErrors('E022: The choosen group name is already use in an other rallye/group.');
          }
        }

        $groups = Group::where('rallye_id', $rallye->id)->get();
        if ($request->has('eventDate')) {
          $eventDate = $this->getDateInMySQLFormat($request->input('eventDate'));
          foreach ($groups as $group) {
            if (
              $group->rallye->id == $rallye->id
              && $group->name == strtoupper($request->input('name'))
              && $group->eventDate != null && $group->eventDate == $eventDate
            ) {
              return back()->withErrors('E023: The is already an event for the choosen rallye with the same date');
            }
          }
        }
      }

      // adding new group
      $group = new  Group;
      $group->name = strtoupper($request->input('name'));
      $group->rallye_id = $request->input('rallye_id');
      $group->user_id = Auth::user()->id;

      // set start date/end date from eventDate
      if ($request->has('eventDate')) {
        $group->eventDate = $this->getDateInMySQLFormat($request->input('eventDate'));
        $date = new Carbon($group->eventDate);

        $date_calendar_year = $date->year;
        $date_calendar_month = $date->month;

        if ($date_calendar_month < 9) {
          $group->start_year = $date_calendar_year - 1;
          $group->end_year = $date_calendar_year;
        } else {
          $group->start_year = $date_calendar_year;
          $group->end_year = $date_calendar_year + 1;
        }
      }
      $group->save();

      return redirect('/smallgroups')->with('success', 'M063: A group has been created');
    } catch (Exception $e) {
      return Redirect::back()->withError('E168: ' . $e->getMessage());
    }
  }


  public function showGroupMembersSameApplicationEvent($id)
  {
    if (Auth::user()->active_profile == config('constants.roles.COORDINATOR') || Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {

      $group = Group::find($id);
      if ($group->rallye->isPetitRallye) {
        $results = null;
        $applications = [];

        $applications = Application::where('rallye_id', $group->rallye->id)
          ->where('status', '1')
          ->where('event_id', strtoupper($group->id))
          ->get();

        Log::stack(['single', 'stdout'])->debug('nbAppblications:' . count($applications));
        if (count($applications) > 0) {
          $bcclist = $this->emailRepository->GetListBccMails($applications);
          Log::stack(['single', 'stdout'])->debug('bcclist:' . $bcclist);

          $rallye_email = $group->rallye->rallyemail;
          $rallye_title = $group->rallye->title;

          $mailBodyPlacehodeler = $this->getMailbody($rallye_title);

          $results = [
            'applications'  => $applications,
            'bcclist'       => $bcclist,
            'rallye_title'  => $rallye_title,
            'rallye_email'  => $rallye_email,
            'mail_body'     => $mailBodyPlacehodeler,
          ];

          return view('members.myeventgroup')->with($results);
        } else {
          return Redirect::back()->withError('E190: You do not belong to any group/Or the group is empty.');
        }
      } else {
        return Redirect::back()->withError('E193: The associated rallye is a standard one.');
      }
    }
  }

  public function showGroupMembersSameApplicationGroupName($id)
  {
    if (Auth::user()->active_profile == config('constants.roles.COORDINATOR') || Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
      $group = Group::find($id);

      if ($group->rallye->isPetitRallye) {
        $results = null;
        $applications = [];

        $applications = Application::where('rallye_id', $group->rallye->id)
          ->where('status', '1')
          ->where('group_name', strtoupper($group->name))
          ->get();


        if (count($applications) > 0) {
          $bcclist = $this->emailRepository->GetListBccMails($applications);
          Log::stack(['single', 'stdout'])->debug('bcclist:' . $bcclist);

          $rallye_email = $group->rallye->rallyemail;
          $rallye_title = $group->rallye->title;

          $mailBodyPlacehodeler = $this->getMailbody($rallye_title);

          $results = [
            'applications'  => $applications,
            'bcclist'       => $bcclist,
            'rallye_title'  => $rallye_title,
            'rallye_email'  => $rallye_email,
            'mail_body'     => $mailBodyPlacehodeler,

          ];

          return view('members.mygroup')->with($results);
        } else {
          return Redirect::back()->withError('E190: You do not belong to any group/Or the group is empty.');
        }
      } else {
        return Redirect::back()->withError('E192: The associated rallye is a standard one.');
      }
    }
  }

  public function showGroupMembers($id)
  {

    $results = null;
    $applications = [];

    $group = Group::find($id);

    if (Auth::user()->active_profile == config('constants.roles.COORDINATOR') || Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
      $applications = Application::where('rallye_id', $group->rallye->id)
        ->where('status', '1')
        ->where('event_id', $group->id)
        ->where('evented', '1')->get();
    }

    Log::stack(['single', 'stdout'])->debug('nbAppblications:' . count($applications));
    if (count($applications) > 0) {
      $bcclist = $this->emailRepository->GetListBccMails($applications);
      Log::stack(['single', 'stdout'])->debug('bcclist:' . $bcclist);

      $results = [
        'applications'  => $applications,
        'bcclist' => $bcclist
      ];

      return view('members.myeventgroup')->with($results);
    } else {
      return Redirect::back()->withError('E189: You do not belong to any group/Or the group is empty.');
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
    $results = null;
    $applications = [];
    $group = Group::find($id);

    if (Auth::user()->active_profile == config('constants.roles.COORDINATOR') || Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {

      $applications = Application::where('rallye_id', $group->rallye->id)
        ->where('status', '1')
        ->where('group_name', $group->name)
        ->where('grouped', true)->get();
    }

    Log::stack(['single', 'stdout'])->debug('nbAppblications:' . count($applications));
    if (count($applications) > 0) {
      $bcclist = $this->emailRepository->GetListBccMails($applications);
      Log::stack(['single', 'stdout'])->debug('bcclist:' . $bcclist);

      $results = [
        'applications'  => $applications,
        'bcclist' => $bcclist
      ];

      return view('members.mygroup')->with($results);
    } else {
      return Redirect::back()->withError('E169: You do not belong to any group/Or the group is empty.');
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
    try {
      //
      $group   = Group::find($id);
      $rallyes = Rallye::orderBy('title', 'asc')->get();

      $data = [
        'rallyes'  => $rallyes,
        'group' => $group
      ];

      return view('smallGroups.edit')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E170: ' . $e->getMessage());
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

      $group = Group::find($id);
      // Check if there is already a grouyp with the same eventDate for the same rallye

      if ($group->rallye != null) {
        $groups = Group::where('rallye_id', $group->rallye->id)->get();
        if ($request->has('eventDate')) {
          $eventDate = $this->getDateInMySQLFormat($request->input('eventDate'));
          foreach ($groups as $grp) {
            if (
              $grp->id != $group->id
              && $grp->rallye->id == $group->rallye->id
              && $grp->name == $group->name
              && $grp->eventDate != null
              && $grp->eventDate == $eventDate
            ) {
              return back()->withErrors('E024: The is already an event for the choosen rallye with the same date');
            }
          }
        }
      }

      // updating the group

      if ($request->has('name')) {
        $group->name = strtoupper($request->input('name'));
      }

      if ($request->has('rallye_id')) {
        $group->rallye_id = $request->input('rallye_id');
      }
      $group->user_id = Auth::user()->id;

      // set start date/end date from eventDate
      if ($request->has('eventDate')) {
        $group->eventDate = $this->getDateInMySQLFormat($request->input('eventDate'));
        $date = new Carbon($group->eventDate);

        $date_calendar_year = $date->year;
        $date_calendar_month = $date->month;

        if ($date_calendar_month < 9) {
          $group->start_year = $date_calendar_year - 1;
          $group->end_year = $date_calendar_year;
        } else {
          $group->start_year = $date_calendar_year;
          $group->end_year = $date_calendar_year + 1;
        }
      }
      $group->save();

      return redirect('/smallgroups')->with('success', 'M064: A group has been updated');
    } catch (Exception $e) {
      return Redirect::back()->withError('E171: ' . $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function destroy(Request $request, $id)
  {
    try {

      // Check existing ApplicationRequest
      $countEngagements = Application::where('group_id', $id)->count();
      $countEngagements += Application::where('event_id', $id)->count();
      // check existing invitation
      $countEngagements += Invitation::where('group_id', $id)->count();
      if ($countEngagements == 0) {
        Group::find($id)->delete();
        return redirect(route('smallgroups'))->with('success', 'M065: group deleted');
      } else {
        return redirect('/smallgroups')->withErrors('E401: Please contact your admin/developer to make this action');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E172: ' . $e->getMessage());
    }
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
