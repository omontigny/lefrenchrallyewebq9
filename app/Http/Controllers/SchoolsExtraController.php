<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Support\Facades\Config;

class SchoolsExtraController extends Controller
{
    // if user is not identified, he will be redirected to the login page
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //
    public function deleteAllSchools()
    {
        School::getQuery()->delete();
        
        $schools = School::all();

        $data = [
            'schools'  => $schools,
            'success'   => 'Irreversible delete has done successuflly!'
        ];

        return to_route('schools.index')->with($data);      
    }  
}
