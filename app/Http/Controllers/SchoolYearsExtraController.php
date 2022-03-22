<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use App\Models\Schoolyear;

class SchoolYearsExtraController extends Controller
{
    // if user is not identified, he will be redirected to the login page
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //
    public function deleteAllSchoolYears()
    {
        
        Schoolyear::getQuery()->delete();
        $schoolYears = Schoolyear::all();

        $data = [
            'schoolYears'  => $schoolYears,
            'success'   => 'Irreversible delete has done successuflly!'
        ];

        return redirect()->route('schoolyears.index')->with($data);        
    }
}
