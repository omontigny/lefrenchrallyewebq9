<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Application;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;


class GroupsExtraController extends Controller
{
    // if user is not identified, he will be redirected to the login page
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function waiteParentGroupById($id)
    {
        try{
            $application = Application::find($id);
            if($application->grouped != 3)
            {
                $application->previous_group_status = $application->grouped;
                $application->grouped = 3;
                $application->save();
                return Redirect::back()->with('success', 'M028: The application request >> Waiting status');
            }
            else
            {
                $application->grouped = $application->previous_group_status;
                $application->save();
                return Redirect::back()->with('success', 'M029: The application request >> has been resumed');
            }
            
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E076: ' . $e->getMessage());
        }
    }
    
    //
    public function deleteAllGroups()
    {
        Group::getQuery()->delete();

        $groups = Group::all();

        $data = [
            'groups'  => $groups,
            'success'   => 'Irreversible delete has done successuflly!'
        ];

        return redirect()->route('groups.index')->with($data);
    }    
}
