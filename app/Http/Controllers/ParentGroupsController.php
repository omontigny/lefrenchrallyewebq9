<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Rallye;
use App\Models\Application;
use App\Models\Admin_Rallye;
use App\Models\CheckIn;
use App\Models\Invitation;
use App\Models\School;
use App\Models\Schoolyear;
use App\Models\Parents;
use App\Models\Children;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\Coordinator_Rallye;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Coordinator;
use App\Models\Parent_Group;
use App\Repositories\EmailRepository;
use Exception;


class ParentGroupsController extends Controller
{

  protected $emailRepository;

  public function __construct(EmailRepository $emailRepository)
  {
    // if user is not identified, he will be redirected to the login page
    $this->middleware('auth');
    $this->emailRepository = $emailRepository;
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

      if (Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {
        $coordinator = Coordinator::where('user_id', Auth::user()->id)->get()->first();
        if ($coordinator != null) {
          $coordinatorRallye = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
            ->where('active_rallye', '1')->first();
          if ($coordinatorRallye != null) {
            if ($coordinatorRallye->rallye->isPetitRallye) {
              $applications = Application::where('rallye_id', $coordinatorRallye->rallye->id)->where('status', '1')->get();
              if (count($applications) == 0) {
                return Redirect::back()->withError('E108: ' . 'No application found!');
              }
            } else {
              return Redirect::back()->withError('E109: ' . 'The active rallye is a standard one');
            }
          }
        }
      } else if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
        $rallyesID[] = ['int'];
        $applications[] = null;
        $adminRallye = Admin_Rallye::where('user_id', Auth::user()->id)->where('active_rallye', '1')->first();
        if ($adminRallye != null) {
          if ($adminRallye->rallye->isPetitRallye) {
            $applications = Application::where('rallye_id', $adminRallye->rallye->id)->where('status', '1')->get();
            if (count($applications) == 0) {
              return Redirect::back()->withError('E110: ' . 'No application found!');
            }
          } else {
            return Redirect::back()->withError('E111: ' . 'The active rallye is a standard one');
          }
        } else {
          return Redirect::back()->withError('E112: ' . 'No application found!');
        }



        // $rallyes = Rallye::where('isPetitRallye', true)->get();
        // foreach($rallyes as $rallye)
        // {
        //     $rallyesID[] = $rallye->id;
        // }
      }

      $rallyes = Rallye::oldest('title')->get();

      $groups = DB::table('groups')
        ->leftJoin('applications', 'applications.group_id', '=', 'groups.id')
        ->select('groups.name', 'groups.rallye_id', DB::raw('count(applications.group_name) as parentsInGroup'))
        ->whereNotNull('groups.name')
        ->groupBy('groups.name', 'groups.rallye_id')
        ->get();


      $groupsCounting = DB::table('applications')
        ->select('applications.group_name', DB::raw('count(applications.group_name) as parentsInGroup'))
        ->groupBy('group_name')
        ->get();

      $data = [
        'rallyes'   => $rallyes,
        'applications' => $applications,
        'groups' => $groups,
        'groupsCounting' => $groupsCounting
      ];

      //$rallyes = Rallye::orderBy('title', 'asc')->get();
      return view('parentGroups.index')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E113: ' . $e->getMessage());
    }
  }

  public function showGroupMembersSameApplicationEvent($id)
  {
    if (Auth::user()->active_profile == config('constants.roles.COORDINATOR') || Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {

      $results = null;
      $group = Group::find($id);

      $applications = Application::where('rallye_id', $group->rallye->id)
        ->where('status', '1')
        ->where('event_id', Str::upper($group->id))
        ->get();

      Log::stack(['single', 'stdout'])->debug('nbAppblications: ' . count($applications));

      if (count($applications) > 0) {
        $bcclist = $this->emailRepository->GetListBccMails($applications);
        Log::stack(['single', 'stdout'])->debug('bcclist: ' . $bcclist);

        $rallye_email = $group->rallye->rallyemail;
        $rallye_title = $group->rallye->title;

        $mailBodyPlacehodeler = $this->getMailbody($rallye_title);

        $results = [
          'applications'  => $applications,
          'bcclist'       => $bcclist,
          'rallye_title'  => $rallye_title,
          'rallye_email'  => $rallye_email,
          'mail_body'     => $mailBodyPlacehodeler,
        ];

        return view('members.myeventgroup')->with($results);
      } else {
        return Redirect::back()->withError('E190: You do not belong to any group/Or the group is empty.');
      }
    }
  }

  public function showGroupMembersSameApplicationGroupName($id)
  {
    if (Auth::user()->active_profile == config('constants.roles.COORDINATOR') || Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {

      $application = Application::find($id);
      if ($application->rallye->isPetitRallye) {
        $group = Group::where('rallye_id', $application->rallye->id)
          ->where('name', $application->group_name)
          ->first();
        if ($group != null) {

          $results = null;
          $applications = [];

          $applications = Application::where('rallye_id', $group->rallye->id)
            ->where('status', '1')
            ->where('group_name', Str::upper($group->name))
            ->get();

          Log::stack(['single', 'stdout'])->debug('nbAppblications: ' . count($applications));

          if (count($applications) > 0) {
            $bcclist = $this->emailRepository->GetListBccMails($applications);
            Log::stack(['single', 'stdout'])->debug('bcclist: ' . $bcclist);

            $rallye_email = $group->rallye->rallyemail;
            $rallye_title = $group->rallye->title;

            $mailBodyPlacehodeler = $this->getMailbody($rallye_title);

            $results = [
              'applications'  => $applications,
              'bcclist'       => $bcclist,
              'rallye_title'  => $rallye_title,
              'rallye_email'  => $rallye_email,
              'mail_body'     => $mailBodyPlacehodeler,
            ];

            return view('members.mygroup')->with($results);
          } else {
            return Redirect::back()->withError('E190: You do not belong to any group/Or the group is empty.');
          }
        } else {
          return Redirect::back()->withError('E198: You do not belong to any group/Or the group is empty.');
        }
      } else {
        return Redirect::back()->withError('E192: The associated rallye is a standard one.');
      }
    }
  }




  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    try {
      //
      $parents = Parents::oldest('parentlastname')->oldest('parentfirstname')->get();
      $rallyes = Rallye::oldest('title')->get();
      $groups = Group::oldest('name')->get();
      $children = Children::oldest('childlastname')->oldest('childfirstname')->get();
      $parentGroups = Parent_Group::all();

      $data = [
        'rallyes'       => $rallyes,
        'parents'       => $parents,
        'groups'        => $groups,
        'parentGroups'  => $parentGroups,
        'children'  => $children,
      ];

      return view('parentGroups.create')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E114: ' . $e->getMessage());
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
    try {

      // Get child and group to check rallyes if are the same
      $application = application::find($request->input('application_id'));
      //$child = Children::where('application_id', $application->id)->first();
      $group = Group::where('name', $request->input('group_id'))->first();

      if ($group == null) {
        $application->grouped = 0;
        $application->previous_group_status = 0;
        $application->group_id = null;
        $application->group_name = '';
        $application->evented = 0;
        $application->event_id = null;
        $application->save();

        return redirect('/parentGroups')->with('success', 'M044: The choosen parent/child has been removed from their group');
      }


      // if group has the same rallye as the child we can affect then the child to the group
      else if ($group->rallye->id == $application->rallye->id) {
        $application->grouped = 1;
        $application->group_id = $group->id;
        $application->group_name = Str::upper($group->name);
        $application->evented = 0;
        $application->event_id = null;

        $application->save();

        // Checkin for Petit Rallye
        if ($application->rallye->isPetitRallye) {
          $ReSetCheckIn = false;
          $child = Children::where('application_id', $application->id)->first();
          $checkins = CheckIn::where('child_id', $child->id)->get();

          // CheckIn if just we have a checkin for the child that is in an other group or an other rallye
          // That means that we have to delete his/her checkins
          // and set them again
          foreach ($checkins as $checkin) {
            if ($checkin->group->name != $application->group_name || $checkin->rallye_id != $application->rallye_id) {
              $ReSetCheckIn = true;
              break;
            }
          }
          // The group is not the same or the rallye is not the same
          if ($ReSetCheckIn && count($checkins) > 0) {
            // delete all checkin for this child and create checkIn for this new group invitations
            foreach ($checkins as $checkin) {
              $childCheckIn = CheckIn::find($checkin->id);
              $childCheckIn->delete();
            }
          }

          // The group is not the same or the rallye is not the same or if the child has no checkins
          if (($ReSetCheckIn && count($checkins) > 0) || count($checkins) == 0) {
            // creating checkin for all invitations
            $invitations = Invitation::where('rallye_id', $application->rallye_id)->get();
            foreach ($invitations as $invitation) {
              if ($invitation->group->name == $application->group_name) {
                $checkin = new CheckIn();
                $checkin->invitation_id = $invitation->id;
                $checkin->group_id = $invitation->group->id;
                $checkin->rallye_id = $invitation->group->rallye->id;
                $checkin->child_id = $child->id;
                $checkin->checkStatus = false;
                $checkin->save();
              }
            }
          }
        }


        return redirect('/parentGroups')->with('success', 'M045: a parent has been added the a group successfully!');
      } else {
        return Redirect::back()->withError('E115: The group and the child have two different rallyes.');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E116: ' . $e->getMessage());
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
    try {
      if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN') || Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {
        $applications = Application::whereNotNull('event_id')->where('event_id', $id)->get();

        return view('members.myeventgroup')->with($applications);
      } else {
        return Redirect::back()->withError('E117: This section is for SUPERADMIN and COORDINATOR only.');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E118: ' . $e->getMessage());
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
    try {
      $parents = Parents::oldest('parentlastname')->oldest('parentfirstname')->get();
      $groups = Group::oldest('name')->get();
      $children = Children::oldest('childlastname')->oldest('childfirstname')->get();
      $parentGroup = Parent_Group::find($id);
      $data = [
        'parentGroup'   => $parentGroup,
        'groups'        => $groups,
        'parents'       => $parents,
        'children' => $children
      ];

      return view('parentGroups.edit')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E119: ' . $e->getMessage());
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
    try {
      $application = Application::find($id);
      if ($application != null) {
        $application->grouped = 0;
        $application->previous_group_status = 0;
        $application->group_name = '';
        $application->save();

        return redirect('/parentGroups')->with('success', 'M046: (Group/Parent/Child) has been updated successfully!');
      } else {
        return Redirect::back()->withError('E120: No application found');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E121: ' . $e->getMessage());
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
  }

  private function getMailbody($rallye_title)
  {
    $mailBodyPlacehodeler = "<p>Dear Parents</p>
       <p><font color=\"grey\">Enter Your email body here...</font></p>
       <br>
       <br>
       <br>
       ---------------
       <p>See you,</p>
       <p>The $rallye_title Coordinators</p>
       ";
    return $mailBodyPlacehodeler;
  }
}
