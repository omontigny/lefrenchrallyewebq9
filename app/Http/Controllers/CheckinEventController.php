<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rallye;
use App\Models\Application;
use App\Models\School;
use App\Models\Schoolyear;
use Intervention\Image\Facades\Image;
use App\User;
use App\Models\Coordinator_Rallye;
use App\Models\Parent_Event;
use Illuminate\Support\Facades\DB;
use App\Models\Parents;
use App\Models\Children;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Coordinator;
use Illuminate\Support\Facades\Config;

class CheckinEventController extends Controller
{
    // if user is not identified, he will be redirected to the login page
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //

    public function index()
    {
        try {

            $parent = Parents::where('user_id', Auth::user()->id)->get()->first();
            if($parent != null)
            {
                $applicationEvent = Application::where('parent_id', $parent->id)->first();

                if($applicationEvent != null)
                {
                    $data = DB::table('applications')
                    ->JOIN('rallyes', 'rallyes.id', '=', 'applications.rallye_id')
                    ->Join('parents', 'parents.id', '=', 'applications.parent_id')
                    ->JOIN('groups', 'groups.id', '=', 'applications.event_id')
                    ->JOIN('children', 'children.application_id', '=', 'applications.id')
                    ->JOIN('checkins', 'checkins.child_id', '=', 'children.id')
                    ->join('invitations', 'invitations.id', '=', 'checkins.invitation_id')
                    ->select('checkins.id','children.childfirstname', 'children.childlastname', 'parents.parentfirstname', 'parents.parentlastname', 'parents.parentmobile', 'checkins.child_present', 'children.childphotopath', 'checkins.')
                    ->where('parents.user_id', '=', Auth::user()->id)
                    ->where('checkins.group_id', '=', $applicationEvent->event_id)
                
                    ->get();
                }  
                else {
                    return Redirect::back()->withError('E050: You do not belong to any event');
                }
            }
            else {
                return Redirect::back()->withError('E051: This section is for parents only');
            }
            
            $results = [
                'data'   => $data
            ];
            
       
        //$rallyes = Rallye::orderBy('title', 'asc')->get();
            return view('checkinEvent.index')->with($results);
    }
    catch (Exception $e) {
        return Redirect::back()->withError('E052: ' . $e->getMessage());
    }
    }

}
