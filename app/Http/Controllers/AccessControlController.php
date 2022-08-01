<?php

namespace App\Http\Controllers;

use App\Models\AccessControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Exception;

class AccessControlController extends Controller
{
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

    //
    try {
      //
      $this->validate($request, [
        //Rules to validate
        'menuoption' => 'required'
      ]);

      // Creating a coordinator user account
      $accessControl = AccessControl::where('menuoption', strtoupper($request->input('menuoption')))->first();
      if ($accessControl == null) {
        // create new access control
        $accessControl = new AccessControl();
        $accessControl->menuoption = strtoupper($request->input('menuoption'));
        $accessControl->status = false;
        $accessControl->save();

        return Redirect::back()->with('success', 'M001: new access control has been added successfully!');
      } else {
        return Redirect::back()->withError('E027: ' . 'an access control is already exists for ' . strtoupper($request->input('menuoption')));
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E028: ' . $e->getMessage());
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
      //Checking if an access control with $id
      $accesControl = AccessControl::find($id);

      if ($accesControl != null) {
        $accesControl->delete();
        return Redirect::back()->with('success', 'M002: The choosen access control has been removed ');
      } else {
        return Redirect::back()->withError('E029:  no access control found to delete');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E030: ' . $e->getMessage());
    }
  }
}
