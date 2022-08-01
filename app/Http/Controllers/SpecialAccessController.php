<?php

namespace App\Http\Controllers;

use App\Models\SpecialAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Exception;

class SpecialAccessController extends Controller
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
    //
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
    try {
      //
      $this->validate($request, [
        //Rules to validate
        'fullname' => 'required',
        'email' => 'required'
      ]);

      // Creating a coordinator user account
      $specialAccess = SpecialAccess::where('email', strtoupper($request->input('email')))->first();
      if ($specialAccess == null) {
        // create new access control
        $specialAccess = new SpecialAccess();
        $specialAccess->fullname = strtoupper($request->input('fullname'));
        $specialAccess->email = strtoupper($request->input('email'));
        $specialAccess->status = false;
        $specialAccess->save();

        // TODO: Send an email here

        return Redirect::back()->with('success', 'M066: new special access has been added successfully!');
      } else {
        return Redirect::back()->withError('E173: ' . 'an access control is already exists for ' . strtoupper($request->input('email')));
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E174: ' . $e->getMessage());
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
    try {
      //Checking if the role to delete is used
      $specialAccess = SpecialAccess::find($id);

      if ($specialAccess != null) {
        $specialAccess->delete();
        return Redirect::back()->with('success', 'M067: Special has been been removed ');
      } else {
        return Redirect::back()->withError('E175: there is no special access with such ID');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E176: ' . $e->getMessage());
    }
  }
}
