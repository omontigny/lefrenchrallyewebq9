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
use App\Models\Parents;
use App\Models\Children;
use App\Models\Admin_Rallye;
use App\Models\Parent_Rallye;
use App\Models\Invitation;
use App\Models\CheckIn;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use App\Models\Coordinator;
use Illuminate\Support\Facades\Mail;

class ApplicationsController extends Controller
{
  // if user is not identified, he will be redirected to the login page
  public function __construct()
  {
    //$this->middleware('auth');
    // TODO: CHeck if the apply mode is activated
  }

  public function fullApplicationForm()
  {
    try {

      $rallyes = Rallye::oldest('title')->get();
      $schools = School::where('added_by', '!=', config('constants.roles.PARENT'))->oldest('name')->get();
      $schoolyears = Schoolyear::oldest('id')->get();

      $data = [
        'rallyes'   => $rallyes,
        'schools'   => $schools,
        'schoolyears'   => $schoolyears
      ];

      return view('applicationrequests.fullapplicationform')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E033: ' . $e->getMessage());
    }
  }

  public function apply()
  {
    $rallyes = Rallye::oldest('title')->paginate(10);
    $applications = Application::all();
    $data = [
      'rallyes'  => $rallyes,
      'applications'   => $applications
    ];

    return view('apply.apply')->with($data);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
    $rallyes = Rallye::oldest('title')->paginate(100);
    // return view('applications.index')->with('rallyes', $rallyes);
    return view('applicationsrequest.index')->with('rallyes', $rallyes);
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
