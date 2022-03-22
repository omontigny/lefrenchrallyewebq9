<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;    
use App\Models\Parents;
use App\Models\Parent_Rallye;
use App\Models\Application;
use App\Models\CheckIn;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class MyInvitationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all my kids invitations ordered by child name for the active rallye
        if(Auth::user()->active_profile == config('constants.roles.PARENT'))
        {   
            $parent = Parents::where('user_id', Auth::user()->id)->get()->first();
            if($parent != null)
            {
                $userId = Auth::user()->id;
                $data = DB::table('applications')
                ->join('rallyes', 'rallyes.id', '=', 'applications.rallye_id')
                ->join('parents', 'parents.id', '=', 'applications.parent_id')
                ->join('children', 'children.application_id', '=', 'applications.id')
                ->join('checkins', 'checkins.child_id', '=', 'children.id')
                ->join('groups', 'groups.id', '=', 'checkins.group_id')
                ->join('invitations', 'invitations.id', '=', 'checkins.invitation_id')
                ->select('checkins.id','children.childfirstname', 'children.childlastname', 'parents.parentfirstname',
                 'parents.parentlastname', 'parents.parentmobile', 'checkins.checkStatus', 'applications.childphotopath',
                 'rallyes.title', 'invitations.theme_dress_code', 'invitations.start_time', 'invitations.end_time',
                 'groups.eventDate')
                ->whereRaw('parents.user_id = ' . $userId)
                ->orderby('rallyes.title', 'asc')
                ->orderby('children.childfirstname', 'asc')
                ->get();

               // ->where('checkins.group_id', '=', $applicationEvent->event_id)
            
                
                //->toSql();

                // DEBUGAJO

                $results = [
                    'data'   => $data
                ];
                
                //$rallyes = Rallye::orderBy('title', 'asc')->get();
                return view('myInvitations.index')->with($results);

                //return $data;

                // END_DEBUGAJO

                if(count($data) > 0)
                {
                    $results = [
                        'data'   => $data
                    ];
                    
                    //$rallyes = Rallye::orderBy('title', 'asc')->get();
                    return view('myInvitations.index')->with($results);
                }
                else {
                    return Redirect::back()->withError('E094: You do not belong to any event');
                }
            }
            else {
                return Redirect::back()->withError('E095: This section is for parents only');
            } 
        }
    }

    public function setAttendingValue($id, $value)
    {
        //
        $checkIn = CheckIn::find($id);
        $checkIn->checkStatus = $value;
        $checkIn->save();
    
    }

    public function attending($id)
    {
        $this->setAttendingValue($id, 1);
        return Redirect::back()->with('success', 'M034: Your confirmation has been saved successfully');
    }

    public function notattending($id)
    {
        $this->setAttendingValue($id, 2);
        return Redirect::back()->with('success', 'M035: The cancellation has been done successfully.');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
