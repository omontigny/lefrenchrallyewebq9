<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parent_Group;
use App\Models\Invitation;
use App\Models\Venue;
use App\Models\Parent_Event;
use App\Models\Parents;
use Illuminate\Support\Facades\Auth;
use App\Models\Parent_Rallye;
use App\Models\CheckIn;
use App\Models\Group;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Redirect;
use App\Models\Children;
use App\Models\Application;
use Illuminate\Support\Facades\Config;

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

          return view('multiCheckin.index')->with($datas);
        } else if (count($applications) > 1) {
          $found = true;
          return redirect('/multicheckin');
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
    if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      $parent = Parents::where('user_id', Auth::user()->id)->first();
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
      $invitation = Invitation::find($id);

      if ($parentRallye->rallye->id == $invitation->rallye->id) {

        // DEBUT
        /////////////////////////////////////////////////////

        try {

          $parent = Parents::where('user_id', Auth::user()->id)->get()->first();

          if ($parent != null) {
            $applicationEvent = Application::where('parent_id', $parent->id)->first();

            if ($applicationEvent != null) {
              $data = DB::table('applications')
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
            } else {
              return Redirect::back()->withError('E090: You do not belong to any event');
            }
          } else {
            return Redirect::back()->withError('E091: You do not have the parent profile.');
          }



          $results = [
            'data'   => $data,
            'invitation_id' => $id
          ];

          return view('checkinEvent.index')->with($results);
        } catch (Exception $e) {
          return Redirect::back()->withError('E092: ' . $e->getMessage());
        }

        // FIN
        /////////////////////////////////////////////////////



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
}
