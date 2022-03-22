<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class FormsController extends BaseController
{
    function basicElements(){
        return view('forms.basic-elements');
    }

    function advanceElements(){
        return view('forms.advance-elements');
    }

    function examples(){
    	return view('forms.examples');
    }
    
    function validation(){
        return view('forms.validation');
    }

    function wizard(){
    	return view('forms.wizard');
    }

    function editors(){
        return view('forms.editors');
    }

    function dragdrop(){
    	return view('forms.dragdrop');
    }
}
