<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rallye;
use App\Models\Coordinator;
use App\Models\Coordinator_Rallye;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Exception;

class RallyeCoordinatorsController extends Controller
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

      // Checking if the user is allowed to go here
      if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
        //
        $rallyeCoordinators = Coordinator_Rallye::oldest('id')->get();
        $coordinators = Coordinator::oldest('firstname')->get();
        $rallyes = Rallye::oldest('title')->get();

        $data = [
          'rallyeCoordinators' => $rallyeCoordinators,
          'rallyes'  => $rallyes,
          'coordinators' => $coordinators
        ];

        return view('rallyeCoordinators.index')->with($data);
      } else {
        return redirect('/welcome')->withErrors('E014: You are not allowed to visit this URL, please contact your super admin to check your profile role.');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E125: ' . $e->getMessage());
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
      //
      $coordinators = Coordinator::oldest('firstname')->get();
      $rallyes = Rallye::oldest('title')->get();

      $data = [
        'rallyes'  => $rallyes,
        'coordinators' => $coordinators
      ];

      return view('rallyeCoordinators.create')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E126: ' . $e->getMessage());
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
      //
      $this->validate($request, [
        //Rules to validate
        'coordinator_id' => 'required',
        'rallye_id' => 'required'
      ]);

      $exists = false;
      $hasActiveRallye = false;
      $coordinatorRallyes = Coordinator_Rallye::all();



      foreach ($coordinatorRallyes as $cr) {
        if (
          $cr->rallye_id == $request->input('rallye_id')
          && $cr->coordinator_id == $request->input('coordinator_id')
        ) {
          $exists = true;
        }

        if ($cr->coordinator_id == $request->input('coordinator_id')) {
          $hasActiveRallye = true;
        }
      }

      if (!$exists) {
        $coordinatorRallye = new  Coordinator_Rallye;
        $coordinatorRallye->rallye_id = $request->input('rallye_id');
        $coordinatorRallye->coordinator_id = $request->input('coordinator_id');
        if (!$hasActiveRallye) {
          $coordinatorRallye->active_rallye = '1';
        }
        $coordinatorRallye->save();
        return redirect('/rallyecoordinators')->with('success', 'M047: A new link has been established (Rallye/Coordinator)');
      } else {
        return redirect('/rallyecoordinators')->withErrors('E015: The choosen coordinator is already linked to the targetted rallye!');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E127: ' . $e->getMessage());
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
      //
      $coordinators = Coordinator::oldest('firstname')->get();
      $rallyes = Rallye::oldest('title')->get();
      $coordinatorRallye = Coordinator_Rallye::find($id);
      $data = [
        'rallyes'  => $rallyes,
        'coordinators' => $coordinators,
        'coordinatorRallye' => $coordinatorRallye
      ];

      return view('rallyeCoordinators.edit')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E129: ' . $e->getMessage());
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
      //
      $this->validate($request, [
        //Rules to validate
        'coordinator_id' => 'required',
        'rallye_id' => 'required'
      ]);

      $coordinatorRallye = Coordinator_Rallye::find($id);

      $coordinatorRallye->rallye_id = $request->input('rallye_id');
      $coordinatorRallye->coordinator_id = $request->input('coordinator_id');
      $coordinatorRallye->save();
      return redirect('/rallyecoordinators')->with('success', 'M048: The (Rallye/Coordinator) has been updated!');
    } catch (Exception $e) {
      return Redirect::back()->withError('E130: ' . $e->getMessage());
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
      //
      $coordinatorRallye = Coordinator_Rallye::find($id);
      //

      if ($coordinatorRallye != null) {
        $coordinatorRallye->delete();
        return redirect('/rallyecoordinators')->with('success', 'M049: (Coordinator/Rallye) link has been deleted');
      } else {
        return redirect('/rallyecoordinators')->withErrors('E016: There is no (Coordinator/Rallye) link that goes with ' . $request->input('calendar_id'));
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E131: ' . $e->getMessage());
    }
  }
}
