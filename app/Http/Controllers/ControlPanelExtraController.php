<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\AccessControl;
use App\Models\SpecialAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControlPanelExtraController extends Controller
{
  // if user is not identified, he will be redirected to the login page
  public function __construct()
  {
    $this->middleware('auth');
  }

  //
  public function controlPanel()
  {
    $userRoles = DB::table('role_user')
      ->join('roles', 'roles.id', '=', 'role_user.role_id')
      ->join('users', 'users.id', '=', 'role_user.user_id')
      ->select('role_user.id as idUserRole', 'users.name', 'users.email')
      ->where('roles.rolename', '=', config('constants.roles.SUPERADMIN'))
      ->get();

    $accessControl = AccessControl::all();

    $specialAccess = SpecialAccess::all();

    if (Auth::user() != null) {
      $user = User::findOrFail(Auth::user()->id);
    }

    $mailBodyPlacehodeler = "
      <p><font color=\"grey\">Enter Your email body here...</font></p>
      <br>
      <br>
      <br>
      ---------------
      <p>See you,</p>
      <p>The FrenchRallye Webmaster</p>
      ";

    $data = [
      'accessControl' => $accessControl,
      'userRoles'     => $userRoles,
      'specialAccess' => $specialAccess,
      'mail_body'     => $mailBodyPlacehodeler,
      'mail_from'     => $user->email
    ];

    return view('controlPanel.controlPanel')->with($data);
  }
}
