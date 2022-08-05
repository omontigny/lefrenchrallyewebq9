<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rallye;
use Illuminate\Support\Str;
use App\Models\Parents;
use App\Models\Children;
use App\Models\Group;
use App\Models\Invitation;
use App\Models\Guest;
use App\Models\Parent_Rallye;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use Illuminate\Support\Facades\Config;
use Exception;
use Illuminate\Support\Carbon;

class GuestsController extends Controller
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
    if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      $parent = Parents::where('user_id', Auth::user()->id)->first();
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
      $found = false;
      if ($parentRallye != null) {
        $applications = Application::where('parent_id', $parent->id)
          ->where('rallye_id', $parentRallye->rallye->id)
          ->where('evented', 1)->get();

        $application = $applications->first();
        if (count($applications) == 1) {
          $found = true;

          # liste des applications ayant le meme event_id (group_id)
          $applications  = Application::where('rallye_id', $application->rallye_id)->where('event_id', $application->event_id)->get();

          $applicationGroupIds = collect();
          # liste des groupes concernés (cas d'enfants dans différents groups)
          foreach ($applications as $application) {
            $applicationGroupIds[] = $application->event_id;
          }

          $limitDate = Carbon::now()->sub(1, 'day');

          $invitations = Invitation::with('group')->where('rallye_id', $parentRallye->rallye->id)->with('user')->get()->where('group.eventDate', '>=', $limitDate)->sortBy('group.eventDate', SORT_REGULAR, false);
          $oldInvitations = Invitation::with('group')->where('rallye_id', $parentRallye->rallye->id)->get()->where('group.eventDate', '<', $limitDate)->sortBy('group.eventDate', SORT_REGULAR, false);

          $groups = Group::oldest('eventDate')->get();
          $applicationGroupIds = $applicationGroupIds->unique();

          /* existe t'il deja une invitation pour ce rallye et ce group  */
          $availableGroupIds = [];
          if ($invitations->where('group_id', $application->event_id)->count() == 0) {
            $availableGroupIds = $applicationGroupIds;
          }

          $data = [
            'application' => $application,
            'groups' => $groups,
            'invitations' => $invitations,
            'oldInvitations' => $oldInvitations,
            'groupsID' => $applicationGroupIds,
            'availableGroupIds' => $availableGroupIds,
            'applications' => $applications
          ];

          return view('guests.index')->with($data);
        } else if (count($applications) > 1) {
          $found = true;
          return redirect('/parentChildren');
        } else {
          $found = false;
        }
      }

      if (!$found) {
        return Redirect::back()->withError('E079: You do not belong to any event group for the active rallye.');
      }
    } else {
      return Redirect::back()->withError('E187: This section is reserved to parent only those affected to event group.');
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
    $this->validate($request, [
      //Rules to validate
      'guest_email' => 'required'
    ]);
    $parent = Parents::where('user_id', Auth::user()->id)->first();
    $child = Children::where('parent_id', $parent->id)->first();
    $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();

    $guest = Guest::where('guestfirstname', ucfirst(Str::lower($request->input('first_name'))))->where('guestlastname', ucfirst(Str::lower($request->input('last_name'))))->get();

    if (count($guest) == 0) {
      # On le crée
      $guest = new  Guest;
      $guest->guestfirstname = ucfirst(Str::lower($request->input('first_name')));
      $guest->guestlastname = ucfirst(Str::lower($request->input('last_name')));
      $guest->guestemail = Str::lower($request->input('guest_email'));
      $guest->guestmobile = Str::lower($request->input('guest_mobile'));
      $guest->invitedby_id = $child->id;
      $guest->rallye_id = 2;
      $guest->group_id = $request->input('calendar_id');
      $guest->nb_invitations += 1;
      $guest->save();
      return Redirect::back()->with('success', 'M100: The extra guest  has been aded successfully.');
    } else {
      # on met à jour son nombre d'invitation et le group_id
      if ($guest->first()->nb_invitations < 2) {
        $guest->first()->nb_invitations += 1;
        $guest->first()->save();
        return Redirect::back()->with('success', 'M101: The extra guest has been updated successfully.');
      } else {
        # code...
        return Redirect::back()->withError('E101: Limit reached this guest has already been invited twice. Sorry.');
      }
      # Stop on ne peut plus l'inviter
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
