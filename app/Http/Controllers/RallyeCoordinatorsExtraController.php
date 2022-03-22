<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rallye;
use App\Models\Coordinator;
use App\Models\Coordinator_Rallye;
use App\Models\Parent_Group;
use Illuminate\Support\Facades\Auth;
use App\Models\Parent_Rallye;
use App\Models\Parents; 
use Illuminate\Support\Facades\Redirect;
use App\Models\Admin_Rallye;
use Illuminate\Support\Facades\Config;

class RallyeCoordinatorsExtraController extends Controller
{

    public function AdminActiveRallyeById($id)
    {
        $adminRallye = Admin_Rallye::find($id);
        $adminRallyes = Admin_Rallye::where('user_id', Auth::user()->id)->get();
        foreach($adminRallyes as $admRally)
        {
            $ralCtr = Admin_Rallye::find($admRally->id);
            $ralCtr->active_rallye = '0';
            $ralCtr->save();
        }
        $adminRallye->active_rallye = '1';
        $adminRallye->save();
        return Redirect::back();

    }

    public function ParentActiveRallyeById($id)
    {
        $parentRallye = Parent_Rallye::find($id);
        $parentRallyes = Parent_Rallye::where('parent_id', $parentRallye->parent_id)->get();
        foreach($parentRallyes as $parRally)
        {
            $ralCtr = Parent_Rallye::find($parRally->id);
            $ralCtr->active_rallye = '0';
            $ralCtr->save();
        }
        $parentRallye->active_rallye = '1';
        $parentRallye->save();
        return Redirect::back();

    }

    public function ActiveRallyeById($id)
    {
        $rallyeCoordinator = Coordinator_Rallye::find($id);
        $rallyeCoordinators = Coordinator_Rallye::where('coordinator_id', $rallyeCoordinator->coordinator_id)->get();
        foreach($rallyeCoordinators as $rallyeCtr)
        {
            $ralCtr = Coordinator_Rallye::find($rallyeCtr->id);
            $ralCtr->active_rallye = '0';
            $ralCtr->save();
        }
        $rallyeCoordinator->active_rallye = '1';
        $rallyeCoordinator->save();
        return Redirect::back();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {

        // Case when the connected user has the active profile: SUPERADMIN
        if(Auth::user()->active_profile == config('constants.roles.SUPERADMIN'))
        {
            // Get the SUPERADMIN
            $adminRallyes = Admin_Rallye::where('user_id', Auth::user()->id)->get();
           
            $data = [
                'adminRallyes' => $adminRallyes
            ];

            return view('RallyeCoordinatorsExtra.indexAdmin')->with($data);
        }

        // Case when the connected user has the active profile: COORDIANTOR
        else if(Auth::user()->active_profile == config('constants.roles.COORDINATOR'))
        {
            // Get the coordinator
            $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
            if($coordinator != null)
            {
                // Get coordinator's rallyes
                $coordinatorRallyes = Coordinator_Rallye::where('coordinator_id', $coordinator->id)->orderBy('id', 'asc')->get();

            }
            
            $data = [
                'coordinatorRallyes' => $coordinatorRallyes
               
        ];

        return view('RallyeCoordinatorsExtra.index')->with($data);
        }
        // Case when the connected user has the active profile: PRARENT
        else if(Auth::user()->active_profile == config('constants.roles.PARENT'))
        {
            // Get the parent 
            $parents = Parents::where('user_id', Auth::user()->id)->first();
            if($parents != null)
            {
                // Get parent's rallyes
                $parentsRallyes = Parent_Rallye::where('parent_id', $parents->id)->orderBy('id', 'asc')->get();
            }
            

            $data = [
                'parentsRallyes' => $parentsRallyes
        ];

        return view('RallyeCoordinatorsExtra.indexParent')->with($data);
        }
        else{
            return redirect('/home')->withErrors('E017: You are not allowed to visit this URL, please contact your super admin to check your profile role.');    
        }

        
    }
    catch (Exception $e) {
        return Redirect::back()->withError('Error: ' . $e->getMessage());
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
