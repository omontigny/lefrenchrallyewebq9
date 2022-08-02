<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Exception;
use App\Models\Rallye;
use App\Models\Coordinator;
use App\Models\Application;
use App\Models\School;
use App\Models\Schoolyear;
use App\Models\Group;
use App\Models\Calendar;
use App\Models\Children;
use App\Models\Parent_Event;
use App\Models\Parent_Rallye;
use App\Models\Parents;
use App\Models\Parent_Group;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Coordinator_Rallye;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;


class RallyesExtraController extends Controller
{
  // if user is not identified, he will be redirected to the login page
  public function __construct()
  {
    $this->middleware('auth');
  }


  public function paymentReminderList()
  {
    $data = null;
    $applications = [];
    $rallyesID = [];


    // if it's a coordinator request.

    if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN') || Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {

      $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
      if ($coordinator != null) {
        $coordinatorRallyes = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
          ->where('active_rallye', '1')->get()->first();

        if ($coordinatorRallyes) {
          if ($coordinatorRallyes->rallye->isPetitRallye) {
            return Redirect::back()->withError('E206: No Payment for the "Petit Rallye". ');
          }

          // Applications on paymentReminder list
          $applications = Application::where('rallye_id', $coordinatorRallyes->rallye->id)->where('status', '4')
            ->get();
        }
      }
    }

    if (count($applications) > 0) {

      $results = [
        'applications'  => $applications
      ];

      return view('rallyes.rallyePaymentReminder')->with($results);
    } else {
      return Redirect::back()->withError('E205:  - You do not belong to any rallye - Or Rallye is empty - Or There is no application on reminder List for the active rallye');
    }
  }

  //
  public function waitingList()
  {

    $data = null;
    $applications = [];
    $rallyesID = [];


    // if it's a coordinator request.

    if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN') || Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {

      $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
      if ($coordinator != null) {
        $coordinatorRallyes = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
          ->where('active_rallye', '1')->get();

        foreach ($coordinatorRallyes as $coordinatorRallye) {
          $rallyesID[] = $coordinatorRallye->rallye_id;
        }

        // Applications on waiting list
        $applications = Application::wherein('rallye_id', $rallyesID)->where('status', '3')
          ->get();
      }
    }

    if (count($applications) > 0) {

      $results = [
        'applications'  => $applications
      ];

      return view('rallyes.rallyeWaitingList')->with($results);
    } else {
      return Redirect::back()->withError('E204:  - You do not belong to any rallye - Or Rallye is empty - Or There is no application on waiting list for the active rallye');
    }
  }


  public function closeAllRallyes()
  {
    try {
      $rallyes = Rallye::all();

      foreach ($rallyes as $rallye) {
        $rallye->status = false;
        $rallye->save();
      }

      $rallyes = Rallye::oldest('title')->paginate(3);

      $data = [
        'rallyes'  => $rallyes,
        'success'  => 'All rallyes have been switched to the closed status'
      ];

      return redirect()->route('rallyes.index')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E140: ' . $e->getMessage());
    }
  }

  public function openAllRallyes()
  {
    try {
      $rallyes = Rallye::all();

      foreach ($rallyes as $rallye) {
        $rallye->status = true;
        $rallye->save();
      }

      $rallyes = Rallye::oldest('title')->paginate(3);

      $data = [
        'rallyes'  => $rallyes,
        'success'   => 'All rallyes have been switched to the opened status'
      ];

      return redirect()->route('rallyes.index')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E141: ' . $e->getMessage());
    }
  }

  public function reverseStatusById($id)
  {
    try {
      $rallye = Rallye::find($id);
      $rallye->status = !$rallye->status;
      $rallye->save();
      return redirect('/rallyes')->with('success', 'M053: Rallye status is updated');
    } catch (Exception $e) {
      return Redirect::back()->withError('E142: ' . $e->getMessage());
    }
  }

  public function deleteAllRallyes()
  {
    try {
      School::getQuery()->delete();
      SchoolYear::getQuery()->delete();
      Group::getQuery()->delete();
      Application::getQuery()->delete();
      Calendar::getQuery()->delete();
      Coordinator::getQuery()->delete();
      Rallye::getQuery()->delete();

      $rallyes = Rallye::all();

      $data = [
        'rallyes'  => $rallyes,
        'success'   => 'Irreversible delete has done successuflly!'
      ];

      return redirect()->route('rallyes.index')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E143: ' . $e->getMessage());
    }
  }
}
