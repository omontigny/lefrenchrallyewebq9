<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rallye;
use App\Models\Application;
use App\Models\School;
use App\Models\Schoolyear;
use Intervention\Image\Facades\Image;
use App\User;
use App\Models\Coordinator_Rallye;
use App\Models\Parent_Event;
use App\Models\CheckIn;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Parents;
use App\Models\Children;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Coordinator;
use Illuminate\Support\Facades\Config;

class CheckinEventExtraController extends Controller
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
      Log::stack(['single', 'stdout'])->debug('Je suis dans CheckinEventExtraController:INDEX');

      $parent = Parents::where('user_id', Auth::user()->id)->get()->first();

      if ($parent != null) {
        $applicationEvent = Application::where('parent_id', $parent->id)->first();

        if ($applicationEvent != null) {
          $data = DB::table('applications')
            ->JOIN('children', 'children.application_id', '=', 'applications.id')
            ->JOIN('checkins', 'checkins.child_id', '=', 'children.id')
            ->join('invitations', 'invitations.id', '=', 'checkins.invitation_id')
            ->select(
              'checkins.id',
              'applications.childfirstname',
              'applications.childlastname',
              'applications.parentfirstname',
              'applications.parentlastname',
              'applications.parentmobile',
              'checkins.child_present',
              'applications.childphotopath'
            )
            //->where('parents.user_id', '=', Auth::user()->id)
            ->where('checkins.group_id', '=', $applicationEvent->event_id)

            ->get();


          /*
                    $data = DB::table('applications')
                    ->JOIN('rallyes', 'rallyes.id', '=', 'applications.rallye_id')
                    ->Join('parents', 'parents.id', '=', 'applications.parent_id')
                    ->JOIN('groups', 'groups.id', '=', 'applications.event_id')
                    ->JOIN('children', 'children.application_id', '=', 'applications.id')
                    ->JOIN('checkins', 'checkins.child_id', '=', 'children.id')
                    ->join('invitations', 'invitations.id', '=', 'checkins.invitation_id')
                    ->select('checkins.id','children.childfirstname', 'children.childlastname', 'parents.parentfirstname', 'parents.parentlastname', 'parents.parentmobile', 'checkins.child_present', 'children.childphotopath')
                    ->where('parents.user_id', '=', Auth::user()->id)
                    ->where('checkins.group_id', '=', $applicationEvent->event_id)

                    ->get();
                    */
        } else {
          return Redirect::back()->withError('E053: You do not belong to any event');
        }
      } else {
        return Redirect::back()->withError('E054: You do not have the parent profile.');
      }



      $results = [
        'data'   => $data
      ];

      Log::stack(['single', 'stdout'])->debug('$results: ' . count($results->data));

      //$rallyes = Rallye::orderBy('title', 'asc')->get();
      return view('checkinEvent.index')->with($results);
    } catch (Exception $e) {
      return Redirect::back()->withError('E055: ' . $e->getMessage());
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
    $checkIn = CheckIn::find($id);

    if ($request->input('action') == "1") {
      //$checkIn->checkStatus = 1;
      $checkIn->child_present = 1;
      $checkIn->save();
      return Redirect::back()->with('success', 'M016: Your confirmation has been saved successfully');
    } else if ($request->input('action') == "0") {
      //$checkIn->checkStatus = 2;
      $checkIn->child_present = 2;
      $checkIn->save();
      return Redirect::back()->with('success', 'M017: The cancellation has been successfully');
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
    //
  }
}
