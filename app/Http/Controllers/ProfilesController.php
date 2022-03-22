<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;

class ProfilesController extends Controller
{
    // if user is not identified, he will be redirected to the login page
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function switchOnAdminProfileById($id)
    {
        try
        {
            $user = User::find($id);
            if($user != null)
            {
                if(Auth::user()->admin != 0)
                {
                    $user->admin = 2;
                    $user->coordinator = ($user->coordinator  != 0)? 1 : 0;
                    $user->parent = ($user->parent != 0)? 1 : 0;
                    $user->active_profile = config('constants.roles.SUPERADMIN');
                    $user->save();
                }
            }

            return redirect('/home');
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E122: ' . $e->getMessage());
        }
    }

    public function switchOnCoordinatorProfileById($id)
    {
        try
        {
            $user = User::find($id);
            if($user != null)
            {
                if(Auth::user()->coordinator != 0)
                {
                    $user->coordinator = 2;
                    $user->admin = ($user->admin  != 0)? 1 : 0;
                    $user->parent = ($user->parent  != 0)? 1 : 0;
                    $user->active_profile = config('constants.roles.COORDINATOR');
                    $user->save();
                }
            }

            return redirect('/home');
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E123: ' . $e->getMessage());
        }
    }


    public function switchOnParentProfileById($id)
    {
        try
        {
            $user = User::find($id);
            if($user != null)
            {
                if(Auth::user()->parent != 0)
                {
                    $user->parent = 2;
                    $user->coordinator = ($user->coordinator  != 0)? 1 : 0;
                    $user->admin = ($user->admin  != 0)? 1 : 0; 
                    $user->active_profile = config('constants.roles.PARENT');
                    $user->save();
                }
            }

            return redirect('/home');
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E124: ' . $e->getMessage());
        }
    }

    //Route::get('profiles/{id}/switchOnAdminProfileById', 'ProfilesController@switchOnAdminProfileById');
    //Route::get('profiles/{id}/switchOnCoordinatorProfileById', 'ProfilesController@switchOnCoordinatorProfileById');
    //Route::get('profiles/{id}/switchOnParentProfileById', 'ProfilesController@switchOnParentProfileById');

}
