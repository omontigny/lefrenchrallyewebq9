<?php

namespace App\Http\Controllers;


use App\Models\Guest;
use App\Models\Parents;
use App\Models\Coordinator;
use App\Models\Coordinator_Rallye;
use App\Models\Admin_Rallye;
use App\Models\Parent_Rallye;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class ExtraGuestsListController extends Controller
{
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
    $rallye_id = $this->getCurrentRallyeId();

    if ($rallye_id) {

      $extracheckins =
        DB::table('guests')
        ->JOIN('rallyes', 'rallyes.id', '=', 'guests.rallye_id')
        ->JOIN('children', 'children.id', '=', 'guests.invitedby_id')
        ->JOIN('parents', 'parents.id', '=', 'children.parent_id')
        ->JOIN('groups', 'groups.id', '=', 'guests.group_id')

        ->select(
          'guests.id',
          'guests.guestfirstname',
          'guests.guestlastname',
          'guests.guestemail',
          'guests.guestmobile',
          'guests.invitedby_id',
          'guests.nb_invitations',
          'parents.parentfirstname',
          'parents.parentlastname',
          'parents.parentmobile',
          'rallyes.title as rallye_title',
          'groups.name as group_name',
          'groups.eventDate',
        )

        ->where('guests.rallye_id', '=', $rallye_id)
        ->get();

      $datas = [
        'extracheckins' => $extracheckins
      ];

      return view('extraGuestsLists.index')->with($datas);
    } else {
      return Redirect::back()->withError('E210:  - You do not belong to any rallye - Or Rallye is empty');
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
    // Log::stack(['single', 'stdout'])->debug("[EXTRAGUEST LIST UPDATE]");

    try {
      $guest = Guest::find($id);
      if ($guest  != null) {
        $guest->guestfirstname = $request->input('guest_firstname');
        $guest->guestlastname = $request->input('guest_lastname');
        $guest->guestemail = $request->input('guest_email');
        $guest->guestmobile = $request->input('guest_mobile');
        $guest->save();

        return redirect('/extraguestsList')->with('success', 'M250: Extra guest has been updated successfully!');
      } else {
        return Redirect::back()->withError('E215: No Extra Guest found');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E216: ' . $e->getMessage());
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
    // Log::stack(['single', 'stdout'])->debug("[EXTRAGUEST LIST DESTROY]");
    try {
      //
      $rallye_id = $this->getCurrentRallyeId();
      $deleted = false;
      $errorMsg = '';
      DB::beginTransaction();
      $extraGuest = Guest::where('id', $id)->get()->first();

      if ($extraGuest != null && $extraGuest->rallye_id == $rallye_id) {
        $extraGuest->delete();
        $deleted = true;
      }
      if ($deleted) {
        DB::commit();
        return redirect('/extraguestsList')->with('success', 'M207: Extra Guest deleted');
      } else {
        DB::rollback();
        return Redirect::back()->withError($errorMsg);
      }
    } catch (Exception $e) {
      DB::rollback();
      return Redirect::back()->withError('E239: ' . $e->getMessage());
    }
  }

  protected function getCurrentRallyeId()
  {
    $rallye_id = null;
    if (Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {
      $coordinator = Coordinator::where('user_id', Auth::user()->id)->get()->first();
      if ($coordinator != null) {
        $coordinatorRallye = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
          ->where('active_rallye', '1')->first();

        if ($coordinatorRallye != null) {
          $rallye_id = $coordinatorRallye->rallye->id;
        }
      }
    } else if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
      $adminRallye = Admin_Rallye::where('user_id', Auth::user()->id)
        ->where('active_rallye', '1')->first();

      if ($adminRallye != null) {
        $rallye_id = $adminRallye->rallye->id;
      }
    } else if (Auth::user()->active_profile == config('constants.roles.PARENT')) {
      $parent = Parents::where('user_id', Auth::user()->id)->first();
      $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
      $rallye_id = $parentRallye->rallye->id;
    }
    return $rallye_id;
  }
}
