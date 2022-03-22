<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rallye;
use App\Models\Children;
use App\Models\CheckIn;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Parents;
use App\Models\Parent_Rallye;
use App\Models\Application;
use Illuminate\Support\Facades\Config;

class CheckinMyKidsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::user()->active_profile == config('constants.roles.PARENT'))
        {   
            $parent = Parents::where('user_id', Auth::user()->id)->first();
            $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
            $found = false;
            if($parentRallye != null)
            {
                $applications = Application::where('parent_id', $parent->id)
                ->where('rallye_id', $parentRallye->rallye->id)
                ->where('evented', 1)->get();
                
                
                if(count($applications) == 1)
                {
                    $application = $applications->first();
                    $found = true;

                    $checkins = DB::table('applications')
                        ->JOIN('rallyes', 'rallyes.id', '=', 'applications.rallye_id')
                        ->JOIN('groups', 'groups.id', '=', 'applications.event_id')
                        ->JOIN('children', 'children.application_id', '=', 'applications.id')
                        ->JOIN('checkins', 'checkins.child_id', '=', 'children.id')
                        ->join('invitations', 'invitations.id', '=', 'checkins.invitation_id')
                        ->select('checkins.id', 'applications.childfirstname', 'applications.childlastname', 'groups.eventDate', 'invitations.venue_address', 'invitations.theme_dress_code', 'invitations.start_time', 'invitations.end_time', 'checkins.checkStatus')
                        ->where('checkins.rallye_id', '=', $parentRallye->rallye->id)
                        ->get();


                        
                        $data = [
                            'checkins' => $checkins
                        ];

                        return view('checkinKids.index')->with($data);
                }
                else if (count($applications) > 1)
                {
                    $found = true;
                    return redirect('/parentChildren');
                }
                else
                {
                    $found = false;
                }
            }
            
            if(!$found)
            {
                return Redirect::back()->withError('E056: You do not belong to any event group for the active rallye. Or no invitation received so far.');
            }
        }
        else
        {
            return Redirect::back()->withError('E057: This section is reserved to parent only those affected to event group.');
        }

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
        //
        if(Auth::user()->active_profile == config('constants.roles.PARENT'))
        {   
            $parent = Parents::where('user_id', Auth::user()->id)->first();
            $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
            $found = false;
            if($parentRallye != null)
            {
                $child = Children::where('application_id', $id)->first();

                if($child != null)
                {
                
                    $checkins = DB::table('applications')
                    ->JOIN('rallyes', 'rallyes.id', '=', 'applications.rallye_id')
                    ->JOIN('groups', 'groups.id', '=', 'applications.event_id')
                    ->JOIN('children', 'children.application_id', '=', 'applications.id')
                    ->JOIN('checkins', 'checkins.child_id', '=', 'children.id')
                    ->join('invitations', 'invitations.id', '=', 'checkins.invitation_id')
                    ->select('checkins.id', 'applications.childfirstname', 'applications.childlastname', 'groups.eventDate', 'invitations.venue_address', 'invitations.theme_dress_code', 'invitations.start_time', 'invitations.end_time', 'checkins.checkStatus')
                    ->where('children.id', '=', $child->id)
                    ->get();

                    $data = [
                        'checkins' => $checkins
                    ];
    
                    return view('checkinKids.index')->with($data);

                }
                else{
                    return Redirect::back()->withError('E058: You Can not upload the child.');
                }
            }

        }
        else
        {
            return Redirect::back()->withError('E059: This section is reserved to parent only those affected to event group.');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //
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
