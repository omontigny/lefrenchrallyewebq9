<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;


class SchoolsController extends Controller
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
      //
      //$rallyes = Rallye::all();
      //$rallyes = Rallye::orderBy('title', 'asc')->take(1)->get();
      $schools = School::orderBy('name', 'asc')->paginate(3);
      //$rallyes = Rallye::orderBy('title', 'asc')->get();
      return view('schools.index')->with('schools', $schools);
    } catch (Exception $e) {
      return Redirect::back()->withError('E152: ' . $e->getMessage());
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
      return view('schools.create');
    } catch (Exception $e) {
      return Redirect::back()->withError('E153: ' . $e->getMessage());
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
        'name' => 'required',
        'state' => 'required'
      ]);

      // Add a school
      $school = new  School;
      $school->name = strtoupper($request->input('name'));
      $school->state = strtoupper($request->input('state'));
      $school->user_id = Auth::user()->id;
      $school->added_by = Auth::user()->name;
      $school->save();

      return redirect('/schools')->with('success', 'M057: A school has been created');
    } catch (Exception $e) {
      return Redirect::back()->withError('E154: ' . $e->getMessage());
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
      $school = School::find($id);
      return view('schools.edit')->with('school', $school);
    } catch (Exception $e) {
      return Redirect::back()->withError('E156: ' . $e->getMessage());
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
      //
      $this->validate($request, [
        //Rules to validate
        'name' => 'required',
        'state' => 'required'
      ]);

      // Add a school
      $school = School::find($id);
      $school->name = strtoupper($request->input('name'));
      $school->state = strtoupper($request->input('state'));
      if (isset($request['isApproved'])) {
        $school->user_id = Auth::user()->id;
        $school->added_by = Auth::user()->name;
        $school->approved = 1;
      }

      $school->save();

      return redirect('/schools')->with('success', 'M058: The school has been updated');
    } catch (Exception $e) {
      return Redirect::back()->withError('E157: ' . $e->getMessage());
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
      // We check if schoolYear to delete if it is used
      $school = School::find($id);
      $application = Application::where('school_id', $id)->first();

      if ($application == null) {
        if ($school != null) {
          $allowed = true;
          $school->delete();
          return redirect('/schools')->with('success', 'M059: school deleted');
        } else {
          $allowed = false;
        }
      } else {
        $allowed = false;
      }

      if (!$allowed) {
        return Redirect::back()->withErrors('E020: There is no current school year called ' . $school->name);
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E158: ' . $e->getMessage());
    }
  }
}
