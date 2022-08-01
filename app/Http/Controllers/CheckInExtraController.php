<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rallye;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Children;
use App\Models\Invitation;
use App\Models\Parents;
use App\Models\Parent_Rallye;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class CheckInExtraController extends Controller
{
  //
  public function checkIn($id)
  {
    Log::stack(['single', 'stdout'])->debug('Je suis dans CheckInExtraController:Checkin');
    if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      // Get connected parent
      $parent = Parents::where('user_id', Auth::user()->id)->first();

      // Get Active Rallye
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();


      $checkins = DB::table('applications')
        ->JOIN('rallyes', 'rallyes.id', '=', 'applications.rallye_id')
        ->JOIN('groups', 'groups.id', '=', 'applications.event_id')
        ->JOIN('children', 'children.application_id', '=', 'applications.id')
        ->JOIN('checkins', 'checkins.child_id', '=', 'children.id')
        ->join('invitations', 'invitations.id', '=', 'checkins.invitation_id')
        ->select('checkins.id', 'applications.childfirstname', 'applications.childlastname', 'groups.eventDate', 'invitations.venue_address', 'invitations.theme_dress_code', 'invitations.start_time', 'invitations.end_time', 'checkins.checkStatus', 'applications.parentemail')
        ->where('checkins.rallye_id', '=', $parentRallye->rallye->id)
        ->get();



      $limitDate = Carbon::now()->sub(1, 'day');

      $invitations = Invitation::with('group')->where('rallye_id', $parentRallye->rallye->id)->get()->where('group.eventDate', '>=', $limitDate)->sortBy('group.eventDate', SORT_REGULAR, false);

      $children = Children::orderBy('childfirstname', 'asc')->get();

      Log::stack(['single'])->debug("children: " . $children);

      $data = [
        'checkins' => $checkins,
        'children' => $children,
        'invitation' => $invitations->first(),
      ];
      return view('checkin.index')->with($data);
    }
  }
}
