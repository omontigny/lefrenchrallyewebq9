<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rallye;
use App\Models\Children;
use Illuminate\Support\Facades\Config;

class CheckInExtraController extends Controller
{
    //
    public function checkIn($id)
    {
         //
         $children = Children::orderBy('childfirstname', 'asc')->get();
         return view('checkin.index')->with('children', $children);

    }
}
