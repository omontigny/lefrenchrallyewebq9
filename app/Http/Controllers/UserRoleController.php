<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Role_User;
use Illuminate\Support\Facades\Redirect;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class UserRoleController extends Controller
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
        'username' => 'required',
        'email' => 'required'
      ]);

      // Creating a coordinator user account
      $user = User::where('email', strtolower($request->input('email')))->first();
      if ($user == null) {
        // create user
        $user = new User();
        $user->name = strtolower($request->input('username'));
        $user->password = Hash::make('userpassword');
        $user->email = strtolower($request->input('email'));
      }

      $user->active_profile = config('constants.roles.SUPERADMIN');
      $user->admin = 2;
      $user->save();

      // create role user
      $role = Role::where('rolename', config('constants.roles.SUPERADMIN'))->first();
      if ($role != null) {
        $role_user = new Role_User;
        $role_user->role_id  = $role->id;
        $role_user->user_id = $user->id;
        $role_user->save();

        return Redirect::back()->with('success', 'M068: new super admin profile has been added');
      } else {
        return Redirect::back()->withError('E177: ' . 'There is no SUPERADMIN role yet.');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E178: ' . $e->getMessage());
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
    try {
      //Checking if the role to delete is used
      $userRole = Role_User::find($id);

      if ($userRole != null) {
        $user = User::find($userRole->user_id);
        ($user->active_profile  == config('constants.roles.SUPERADMIN')) ? '' : $user->active_profile;
        $user->admin = 0;
        if ($user->coordinator == 1) {
          $user->active_profile = config('constants.roles.COORDINATOR');
          $user->coordinator = 2;
        } else if ($user->parent == 1) {
          $user->active_profile = config('constants.roles.PARENT');
          $user->parent = 2;
        }
        $user->coordinator = ($user->coordinator == 2) ? 1 : 0;
        $user->parent = ($user->parent == 2) ? 1 : 0;
        if ($user->coordinator) {
        }
        $user->save();


        $userRole->delete();
        return Redirect::back()->with('success', 'M069: Administrator role has been removed ' . $user->name);
      } else {
        return Redirect::back()->withError('E179: there is no userRole with such ID');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E180: ' . $e->getMessage());
    }
  }
}
