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
use Illuminate\Support\Facades\Log;


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
          $selectIvitations = $invitations->where('group_id', $application->event_id)->count();
          Log::stack(['single', 'stdout'])->debug("nb invitations: " . $selectIvitations);

          if ($invitations->where('group_id', $application->event_id)->count() != 0) {
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
    // rules
    // 1. A host child can only invite 1 extra guest per event
    // 2. One specific extra guest can only participate twice a year

    $this->validate($request, [
      //Rules to validate
      'guest_email' => 'required'
    ]);
    $parent = Parents::where('user_id', Auth::user()->id)->first();
    $child = Children::where('parent_id', $parent->id)->first(); // revoir car pas sur qu'on tape sur le bon enfant
    $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();

    $guest = Guest::where('guestfirstname', ucfirst(Str::lower($request->input('first_name'))))->where('guestlastname', Str::upper($request->input('last_name')))->get();
    $guestForThisEvent = $guest->where('group_id', $request->input('group_id'));

    $nbGuestInvitations = $guest->sum('nb_invitations');
    Log::stack(['single', 'stdout'])->debug("Nb invitations for this extra guest: " . $nbGuestInvitations);


    $nbParentInvitationsForThisEvent = Guest::where('invitedby_id', $child->id)->where('group_id', $request->input('group_id'))->sum('nb_invitations');
    Log::stack(['single', 'stdout'])->debug("Nb invitations for this parent: " . $nbParentInvitationsForThisEvent);

    $nbParentTotalInvitations = Guest::where('invitedby_id', $child->id)->sum('nb_invitations');
    Log::stack(['single', 'stdout'])->debug("Nb invitations for this parent: " . $nbParentTotalInvitations);

    if ($nbParentInvitationsForThisEvent >= 1) {
      return Redirect::back()->withError("E100: Sorry, you already invited one extra guest for this event");
    }

    if ($nbGuestInvitations >= 2) {
      return Redirect::back()->withError("E102: Sorry, {$guest->first()->guestfirstname} {$guest->first()->guestlastname} has already been invited twice.");
    }
    if (count($guestForThisEvent) == 0) {
      # On le crée
      $guest = new Guest;
      $guest->guestfirstname = ucfirst(Str::lower($request->input('first_name')));
      $guest->guestlastname = Str::upper($request->input('last_name'));
      $guest->guestemail = Str::lower($request->input('guest_email'));
      $guest->guestmobile = Str::lower($request->input('guest_mobile'));
      $guest->guestparentmobile = Str::lower($request->input('guest_parentmobile'));
      $guest->invitedby_id = $child->id;
      $guest->rallye_id = $parentRallye->rallye_id;
      $guest->group_id = $request->input('group_id');
      $guest->nb_invitations += 1;
      $guest->save();
      return Redirect::back()->with('success', "M103: The Extra Guest: '{$guest->guestfirstname} {$guest->guestlastname}' has been added successfully.");
    } else {
      $guest_fullname = "{$guest->first()->guestfirstname} {$guest->first()->guestlastname}";
      if ($guest->first()->group_id == $request->input('group_id')) {
        return Redirect::back()->withError("E104: Sorry, '{$guest_fullname}' has already been invited for this event");
      } else if ($guest->first()->nb_invitations < 2) {
        # $guest->first()->group_id  = $request->input('group_id');
        # guest->first()->invitedby_id = $child->id;
        $guest->first()->nb_invitations += 1;
        $guest->first()->save();
        return Redirect::back()->with('success', "M105: The extra guest '{$guest_fullname}' has been updated successfully.");
      } else {
        # Stop on ne peut plus l'inviter
        return Redirect::back()->withError("E106: Sorry, Limit reached for '{$guest_fullname}' . This guest has already been invited twice this season");
      }
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
