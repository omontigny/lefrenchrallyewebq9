<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class GuestsExtraController extends Controller
{
    //
    // if user is not identified, he will be redirected to the login page
    public function __construct()
    {
        $this->middleware('auth');
    }
}
