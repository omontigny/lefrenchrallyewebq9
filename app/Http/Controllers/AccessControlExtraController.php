<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessControl;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;

class AccessControlExtraController extends Controller
{
    //
    public function reverseAccessControlStatusById($id)
    {
        //
        try
        {
        //Checking if an access control with $id
        $accesControl = AccessControl::find($id);
        
        if($accesControl != null)
        {            
            $accesControl->status = !$accesControl->status;
            $accesControl->save();
            return Redirect::back()->with('success', 'M003: The access control for ' . $accesControl->menuoption . ' has been switched!');
        }
        else{
            return Redirect::back()->withError('E031: no access control found to switch');
        }
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E032: ' . $e->getMessage());
        }

    }
}
