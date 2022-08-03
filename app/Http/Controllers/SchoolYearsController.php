<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schoolyear;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use App\Models\MembershipPrice;
use Exception;


class SchoolYearsController extends Controller
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
      $schoolYears = SchoolYear::oldest('current_level')->paginate(3);
      return view('schoolyears.index')->with('schoolYears', $schoolYears);
    } catch (Exception $e) {
      return Redirect::back()->withError('E159: ' . $e->getMessage());
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
      return view('schoolyears.create');
    } catch (Exception $e) {
      return Redirect::back()->withError('E160: ' . $e->getMessage());
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
        'current_level' => 'required',
        'next_level' => 'required'
      ]);

      // Add a school year level
      $schoolyear = new  SchoolYear;
      $schoolyear->current_level = Str::upper($request->input('current_level'));
      $schoolyear->next_level = Str::upper($request->input('next_level'));
      $schoolyear->user_id = Auth::user()->id;
      $schoolyear->save();

      return redirect('/schoolyears')->with('success', 'M060: school year has been created');
    } catch (Exception $e) {
      return Redirect::back()->withError('E161: ' . $e->getMessage());
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
      $schoolYear = SchoolYear::find($id);
      return view('schoolyears.edit')->with('schoolYear', $schoolYear);
    } catch (Exception $e) {
      return Redirect::back()->withError('E163: ' . $e->getMessage());
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
        'current_level' => 'required',
        'next_level' => 'required'
      ]);

      // Add a school level
      $schoolYear = SchoolYear::find($id);
      $schoolYear->current_level = Str::upper($request->input('current_level'));
      $schoolYear->next_level = Str::upper($request->input('next_level'));

      $schoolYear->user_id = Auth::user()->id;
      $schoolYear->save();

      return redirect('/schoolyears')->with('success', 'M061: school year has been updated');
    } catch (Exception $e) {
      return Redirect::back()->withError('E164: ' . $e->getMessage());
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
      $schoolYear = SchoolYear::find($id);
      if ($schoolYear == null) {
        return redirect('/schoolyears')->withErrors('E021: There is no current school year that is related to the ID ' . $id);
      }

      // Check if there is any application related to the targeted SchoolYear
      $application = Application::where('schoolyear_id', $id)->first();
      // Check if there is any membershipPrice related to the targeted SchoolYear
      $membershipPrice = MembershipPrice::where('schoolyear_id', $id)->first();
      if ($application == null && $membershipPrice == null) {
        $schoolYear->delete();
        return redirect('/schoolyears')->with('success', 'M062: school year deleted');
      } else {
        return redirect('/schoolyears')->withErrors('E400: The school year is related to an application/a membership price');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E165: ' . $e->getMessage());
    }
  }
}
