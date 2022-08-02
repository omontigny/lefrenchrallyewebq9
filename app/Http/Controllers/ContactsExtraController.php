<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AccessControl;
use App\Models\SpecialAccess;
use App\Models\Application;
use App\Models\Parent_Group;
use App\Models\Rallye;
use Illuminate\Support\Facades\Config;

class ContactsExtraController extends Controller
{
    //
    public function contacts()
    {
        $waitingList = Application::where('status', 3)->oldest('parentlastname')->oldest('parentfirstname')->get();
        $userRoles = DB::table('role_user')
        ->join('roles', 'roles.id', '=', 'role_user.role_id')
        ->join('users', 'users.id', '=', 'role_user.user_id')
        ->select('role_user.id as idUserRole', 'users.name', 'users.email')
        ->where('roles.rolename', '=', config('constants.roles.SUPERADMIN'))
            ->get();

        $membersByEvent = DB::table('parent_group')
         ->join('groups', 'groups.id', '=', 'parent_group.group_id')
         ->join('rallyes', 'rallyes.id', '=', 'groups.rallye_id')
         ->SELECT(DB::RAW('count(*) as nbMembers, groups.id, groups.name, rallyes.title'))
         ->GROUPBY('groups.id', 'groups.name', 'rallyes.title')
         ->get();


         $membersByRallye = DB::table('parent_group')
         ->join('groups', 'groups.id', '=', 'parent_group.group_id')
         ->join('rallyes', 'rallyes.id', '=', 'groups.rallye_id')
         ->SELECT(DB::RAW('count(*) as nbMembers, rallyes.id, rallyes.title'))
         ->GROUPBY('rallyes.id', 'rallyes.title')
         ->get();

        $accessControl = AccessControl::all(); 
        $specialAccess = SpecialAccess::all();
        $parentGroups = Parent_Group::oldest('id')->get();
        
        $EmailsByGroupId = [];

        $data = [
            'waitingList' => $waitingList,
            'accessControl'  => $accessControl,
            'userRoles' => $userRoles,
            'specialAccess' => $specialAccess,
            'parentGroups' => $parentGroups,
            'membersByEvent' => $membersByEvent,
            'membersByRallye' => $membersByRallye
        ];
        
        return view('contacts.contacts')->with($data);
    }
}
