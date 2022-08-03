<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Rallye;
use Illuminate\Support\Facades\Auth;
use App\Models\Coordinator;
use App\Models\Coordinator_Rallye;
use App\Models\Application;
use App\Models\Invitation;
use App\Models\Admin_Rallye;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;

class GroupsController extends Controller
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
    try {
      $rallye_id = '';
      if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
        $adminRallye = Admin_Rallye::where('user_id', Auth::user()->id)
          ->where('active_rallye', '1')->first();

        if ($adminRallye != null) {
          $rallye_id = $adminRallye->rallye->id;
          $rallye = Rallye::find($rallye_id);
          if ($rallye->isPetitRallye) {
            return Redirect::back()->withError('E238: The active rallye is a (Smallone).');
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
            if ($rallye->isPetitRallye) {
              return Redirect::back()->withError('E239: The active rallye is a (Smallone).');
            }
            //
          } else {
            return Redirect::back()->withError('E240: Please select your active rallye');
          }
        } else {
          return Redirect::back()->withError('E241: Your coordinator profile has to be verified, please contact your admin.');
        }
      }

      if ($rallye_id != '') {
        $groups = Group::where('rallye_id', $rallye_id)
          ->oldest('name')->paginate(100);
        return view('groups.index')->with('groups', $groups);
      } else {
        return Redirect::back()->withError('E233: This section is for administor/Coordinator only - Check your active rallye');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E068: ' . $e->getMessage());
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
            return Redirect::back()->withError('E242: Please select your active rallye');
          }
        } else {
          return Redirect::back()->withError('E243: Your coordinator profile has to be verified, please contact your admin.');
        }
      }

      if ($rallye_id != '') {
        // rallye std
        $rallyes = Rallye::where('id', $rallye_id)
          ->where('isPetitRallye', '0')->oldest('title')->get();
        $data = [
          'rallyes'  => $rallyes
        ];

        return view('groups.create')->with($data);
      } else {
        return Redirect::back()->withError('E245: This section is for administor/Coordinator only.');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E246: ' . $e->getMessage());
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
      $eventDate = Carbon::createFromFormat('d/m/Y', $request->input('eventDate'))->format('Y-m-d');
      if ($rallye != null) {
        if ($rallye->isPetitRallye) {
          return back()->withErrors('E006: The (Petit rallye) is not allowed to be managed here.');
        }
        $groups = Group::where('rallye_id', $rallye->id)->get();
        if ($request->has('eventDate')) {
          foreach ($groups as $group) {
            if (
              $group->rallye->id == $rallye->id
              &&
              $group->eventDate != null && $group->eventDate == $eventDate
            ) {
              return back()->withErrors('E007: The is already an event for the choosen rallye with the same date');
            }
          }
        }
      }

      // adding new group
      $group = new  Group;
      $group->name = '';
      if ($request->has('name')) {
        $group->name = $request->input('name');
      }
      $group->rallye_id = $request->input('rallye_id');
      $group->user_id = Auth::user()->id;

      // set start date/end date from eventDate
      if ($request->has('eventDate')) {
        $group->eventDate = $eventDate;
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

      return redirect('/groups')->with('success', 'M025: A group has been created');
    } catch (Exception $e) {
      return Redirect::back()->withError('E069: ' . $e->getMessage());
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
    try {


      if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN') || Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {
        $applications = Application::where('event_id', $id)->get();

        if ($applications != null && count($applications) > 0) {
          $data = [
            'applications'  => $applications
          ];

          return view('members.myeventgroup')->with($data);
        } else {
          return Redirect::back()->withError('E070: There is no application attached to the selected event group.');
        }
      } else {
        return Redirect::back()->withError('E071: This section is for SUPERADMIN and COORDINATOR only.');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E072: ' . $e->getMessage());
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
      $group = Group::find($id);
      $rallyes = Rallye::oldest('title')->get();

      $data = [
        'rallyes'  => $rallyes,
        'group' => $group,
      ];

      return view('groups.edit')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E073: ' . $e->getMessage());
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
        if ($group->rallye->isPetitRallye) {
          return back()->withErrors('E008: The (Petit rallye) is not allowed to be managed here.');
        }
        $groups = Group::where('rallye_id', $group->rallye->id)->get();
        if ($request->has('eventDate')) {
          $eventDate = Carbon::createFromFormat('d/m/Y', $request->input('eventDate'))->format('Y-m-d');
          foreach ($groups as $grp) {
            if (
              $grp->id != $group->id
              && $grp->rallye->id == $group->rallye->id
              &&
              $grp->eventDate != null && $grp->eventDate == $eventDate
            ) {
              return back()->withErrors('E009: The is already an event for the choosen rallye with the same date');
            }
          }
        }
      }

      // updating the group

      if ($request->has('name')) {
        $group->name = $request->input('name');
      }

      if ($request->has('rallye_id')) {
        $group->rallye_id = $request->input('rallye_id');
      }
      $group->user_id = Auth::user()->id;

      // set start date/end date from eventDate
      if ($request->has('eventDate')) {
        $eventDate = Carbon::createFromFormat('d/m/Y', $request->input('eventDate'))->format('Y-m-d');
        $group->eventDate = $eventDate;
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

      return redirect('/groups')->with('success', 'M026: A group has been updated');
    } catch (Exception $e) {
      return Redirect::back()->withError('E074: ' . $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  /*public function destroy($id)
    {
        //
        $group = Group::find($id);
        $group->delete();
        return redirect('/groups')->with('success', 'A group has been deleted');
    }*/

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
        return redirect(route('groups'))->with('success', 'M065: group deleted');
      } else {
        return redirect('groups')->withErrors('E401: Please contact your admin/developer to make this action');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E172: ' . $e->getMessage());
    }
  }
}
