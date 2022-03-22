<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class LeFrenchRallyeController extends Controller
{
    public function welcomeRequest()
    {
        $title = 'Le French Rallye';
        return view('lefrenchrallye/welcome')->with('title', $title);
    }
    //
    public function welcome()
    {
        $title = 'Le French Rallye';
        
        if(!Auth::check())
        {
            Session::flush();
        }
        
        return view('lefrenchrallye/welcome')->with('title', $title);
    }

    public function home()
    {
        //return Config::get('constants.roles.SUPERADMIN');
        return view('lefrenchrallye/home');
    }
}
