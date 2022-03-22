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
use Illuminate\Support\Facades\DB;
use App\Models\Admin_Rallye;    
use Illuminate\Support\Facades\Config;

use App\Models\Parents;
use App\Models\Children;

use App\Models\Group;

use Exception;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Auth;
use App\Models\Coordinator;
use App\Models\Parent_Group;

class ParentEventsController extends Controller
{
    // if user is not identified, he will be redirected to the login page
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            //
            //$rallyes = Rallye::all();
            //$rallyes = Rallye::orderBy('title', 'asc')->take(1)->get();
            
            if(Auth::user()->active_profile == config('constants.roles.COORDINATOR'))
            {
                $coordinator = Coordinator::where('user_id', Auth::user()->id)->get()->first();
                if($coordinator != null)
                {
                    $coordinatorRallye = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
                    ->where('active_rallye', '1')->first();
                    if($coordinatorRallye != null)
                    {
                        $applications = Application::where('rallye_id', $coordinatorRallye->rallye->id)
                            ->where('status', '1')
                            ->where('is_boarder', '0')
                            ->get();
                        
                        if(count($applications) == 0 )
                        {
                            return Redirect::back()->withError('E096: ' . 'No application found!');
                        }
                    
                    }
                }
            }
            else if(Auth::user()->active_profile == config('constants.roles.SUPERADMIN'))

            {
                $rallyesID[] = ['int'];
                $applications[] = null;
                $adminRallye = Admin_Rallye::where('user_id', Auth::user()->id)->where('active_rallye', '1')->first();
                if($adminRallye != null)
                {
                    $applications = Application::where('rallye_id', $adminRallye->rallye->id)
                    ->where('status', '1')
                    ->where('is_boarder', '0')
                    ->get();

                    if(count($applications) == 0 )
                    {
                        return Redirect::back()->withError('E097: ' . 'No application found!/ Or no events dates for the associated group');
                    }
                }
                else
                {
                    return Redirect::back()->withError('E098: ' . 'No application found!');
                }



                // $rallyes = Rallye::where('isPetitRallye', true)->get();
                // foreach($rallyes as $rallye)
                // {
                //     $rallyesID[] = $rallye->id;
                // }                
            }
         
            $rallyes = Rallye::orderBy('title', 'asc')->get();
          
            $groups = DB::table('groups')
                ->leftJoin('applications', 'applications.event_id', '=', 'groups.id') 
                ->select('groups.id', 'groups.name', 'groups.rallye_id', 'groups.eventDate', DB::raw('count(applications.id) as parentsInEvents'))
                ->whereNotNull('groups.name')
             ->groupBy('groups.id', 'groups.name', 'groups.eventDate', 'groups.rallye_id')
             ->get();

            $grps = Group::all();
         

        $groupsCounting = DB::table('applications')
        ->select('applications.group_name',DB::raw('count(applications.group_name) as parentsInGroup'))
     ->groupBy('group_name')
     ->get();
            
            $data = [
                'rallyes'   => $rallyes,
                'applications' => $applications,
                'groups' => $groups,
                'groupsCounting' => $groupsCounting,
                'grps' => $grps
            ];
    
                //$rallyes = Rallye::orderBy('title', 'asc')->get();
                return view('parentEvents.index')->with($data);
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E099: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try
        {
        //
        $parents = Parents::orderBy('parentlastname', 'asc')->orderBy('parentfirstname', 'asc')->get(); 
        $rallyes = Rallye::orderBy('title', 'asc')->get();
        $groups = Group::orderBy('name', 'asc')->get();
        $children = Children::orderBy('childlastname', 'asc')->orderBy('childfirstname', 'asc')->get();
        $parentGroups = Parent_Group::all();

        $data = [
            'rallyes'       => $rallyes,
            'parents'       => $parents,
            'groups'        => $groups,
            'parentGroups'  => $parentGroups,
            'children'  => $children,
        ];

        return view('parentGroups.create')->with($data);
    }
    catch (Exception $e) {
        return Redirect::back()->withError('E100: ' . $e->getMessage());
    }
    }

    public function createById($id)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            // Get child and group to check rallyes if are the same
            $application = application::find($request->input('application_id'));
            $child = Children::where('application_id', $application->id)->first();
            $group = Group::where('id', $request->input('group_id'))->first();
            

            if($group == null)
            {
                $application->evented = 0;
                //$application->previous_group_status = 0;
                $application->event_id = null;
                //$application->group_name = '';

                $application->save();

                return redirect('/parentEvents')->with('success', 'M036: The choosen parent/child has been removed from their event group');
            }

            // if group has the same rallye as the child we can affect then the child to the group
            if($group->rallye->id == $application->rallye->id)
            {
                $application->evented = 1;
                $application->event_id = $group->id;
                //$application->group_name = strtoupper($group->name);
                $application->save();

                return redirect('/parentEvents')->with('success', 'M037: a parent has been added the a parentEvent successfully!');

            }

        }
        catch (Exception $e) {
            return Redirect::back()->withError('E101: ' . $e->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id

     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            if(Auth::user()->active_profile == config('constants.roles.SUPERADMIN') || Auth::user()->active_profile == config('constants.roles.COORDINATOR'))
            {
                $applications = Application::whereNotNull('event_id')->where('event_id', $id)->get();
                
                return view('members.myeventgroup')->with($applications); 

            }
            else
            {
                return Redirect::back()->withError('E102: This section is for SUPERADMIN and COORDINATOR only.');
            }

        }
        catch(Exception $e) {
            return Redirect::back()->withError('E103: ' . $e->getMessage());
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
        try
        {
            $parents = Parents::orderBy('parentlastname', 'asc')->orderBy('parentfirstname', 'asc')->get();
            $groups = Group::orderBy('name', 'asc')->get();
            $children = Children::orderBy('childlastname', 'asc')->orderBy('childfirstname', 'asc')->get();
            $parentGroup = Parent_Group::find($id);
            $data = [
                'parentGroup'   => $parentGroup,
                'groups'        => $groups,
                'parents'       => $parents,
                'children' => $children
            ];

            return view('parentGroups.edit')->with($data);
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E104: ' . $e->getMessage());
        }
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
        try
        {
            $application = Application::find($id);
            if($application != null)
            {
                $application->evented = 0;
                //$application->previous_group_status = 0;
                $application->event_id = null;
                //$application->group_name = '';
                $application->save();
                
                 return redirect('/parentEvents')->with('success', 'M038: (Group/Parent/Child) has been updated successfully!');     
            }
            else
            {
                return Redirect::back()->withError('E105: No application found');
            }
            
    
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E106: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
        $parentGroup = Parent_Group::find($id);

        if($parentGroup != null)
        {
            $parentGroup->parent->affected = false;
            $parentGroup->parent->save();
            $parentGroup->delete();
            
            return redirect('/parentGroups')->with('success', 'M039: Parent/Group link has been deleted');
        }
        else
        {
            return redirect('/parentGroups')->withErrors('E012: There is no parent/group link with the ID:  ' . $id);
        }
        }
        catch (Exception $e) {
            return Redirect::back()->withError('E107: ' . $e->getMessage());
        }
        
    }
}
