<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rallye;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Group;
use Illuminate\Support\Facades\Config;
use App\Models\Coordinator;
use App\Models\Coordinator_Rallye;
use App\Models\Admin_Rallye;
use App\Models\Parent_Rallye;
use App\Models\Parents;


class CalendarsController extends Controller
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
    //Get Current activeRallye_id
    $rallye_id = $this->getCurrentRallyeId();

    //Show only the events related to the current activeRallye Coordinator. No need to see alls the events
    if ($rallye_id != null) {
      $datas = DB::table('groups')
        ->join('rallyes', 'rallyes.id', '=', 'groups.rallye_id')
        ->select('rallyes.title', 'groups.start_year', 'groups.end_year', 'groups.name', 'groups.eventDate')
        ->where('rallyes.id', $rallye_id)
        ->oldest('rallyes.title')
        ->oldest('groups.start_year')
        ->oldest('groups.end_year')
        ->get();
    } else {
      $datas = DB::table('groups')
        ->join('rallyes', 'rallyes.id', '=', 'groups.rallye_id')
        ->select('rallyes.title', 'groups.start_year', 'groups.end_year', 'groups.name', 'groups.eventDate')
        ->oldest('rallyes.title')
        ->oldest('groups.start_year')
        ->oldest('groups.end_year')
        ->get();
    }

    $rallyes = Rallye::oldest('title')->get();
    $groups = Group::all();

    $data = [
      'groups' => $groups,
      'rallyes'  => $rallyes,
      'datas' => $datas
    ];

    return view('calendars.index')->with($data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
    $rallyes = Rallye::all();
    return view('calendars.create')->with('rallyes', $rallyes);
  }

  protected function getCurrentRallyeId()
  {
    $rallye_id = null;
    if (Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {
      $coordinator = Coordinator::where('user_id', Auth::user()->id)->get()->first();
      if ($coordinator != null) {
        $coordinatorRallye = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
          ->where('active_rallye', '1')->first();

        if ($coordinatorRallye != null) {
          $rallye_id = $coordinatorRallye->rallye->id;
        }
      }
    } else if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
      $adminRallye = Admin_Rallye::where('user_id', Auth::user()->id)
        ->where('active_rallye', '1')->first();

      if ($adminRallye != null) {
        $rallye_id = $adminRallye->rallye->id;
      }
    } else if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      $parent = Parents::where('user_id', Auth::user()->id)->first();
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
      $rallye_id = $parentRallye->rallye->id;
    }
    return $rallye_id;
  }
}
