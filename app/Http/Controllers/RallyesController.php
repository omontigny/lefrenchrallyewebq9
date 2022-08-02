<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rallye;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin_Rallye;
use App\Models\Coordinator_Rallye;
use App\Models\Application;
use App\Models\Group;

use App\User;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;

class RallyesController extends Controller
{
  // if user is not identified, he will be redirected to the login page
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function CheckUserAccess()
  {

    $userAccess = false;
    if (
      Auth::user()->active_profile == config('constants.roles.SUPERADMIN')
      && Auth::user()->admin == 2
    ) {
      $userAccess = true;
    }

    return $userAccess;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      if (!$this->CheckUserAccess()) {
        return redirect('/welcome')->withError('E300: This sestion is for SUPER ADMIN only.');
      }
      //
      //$rallyes = Rallye::all();
      //$rallyes = Rallye::orderBy('title', 'asc')->take(1)->get();
      $rallyes = Rallye::orderBy('title', 'asc')->paginate(10);
      //$rallyes = Rallye::orderBy('title', 'asc')->get();
      return view('rallyes.index')->with('rallyes', $rallyes);
    } catch (Exception $e) {
      return Redirect::back()->withError('E133: ' . $e->getMessage());
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
      if (!$this->CheckUserAccess()) {
        return redirect('/welcome')->withError('E300: This sestion is for SUPER ADMIN only.');
      }
      //
      return view('rallyes.create');
    } catch (Exception $e) {
      return Redirect::back()->withError('E134: ' . $e->getMessage());
    }
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
      if (!$this->CheckUserAccess()) {
        return redirect('/welcome')->withError('E300: This sestion is for SUPER ADMIN only.');
      }

      //
      $this->validate($request, [
        //Rules to validate
        'title' => 'required'
      ]);

      $rallye = Rallye::where('title', Str::upper($request->input('title')))->first();
      if ($rallye == null) {
        // Add a rallye
        $rallye = new  Rallye;
        $rallye->title = Str::upper($request->input('title'));
        $rallye->rallyemail = Str::lower($request->input('rallyemail'));
        if ($request->has('isPetitRallye')) {
          $rallye->isPetitRallye = true;
        }
        $rallye->user_id = Auth::user()->id;
        $rallye->save();


        // Adding the new rallye to admin_rallye (to manage active rallye for the admin)
        $adminRallye = new Admin_Rallye;
        $adminRallye->user_id = Auth::user()->id;
        $adminRallye->rallye_id = $rallye->id;
        $adminRallye->save();

        return redirect(route('rallyes'))->with('success', 'M050: Rallye created');
      } else {
        return redirect('/rallyes')->withErrors('E018: There is already a rallye called ' . Str::upper($request->input('title')));
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E135: ' . $e->getMessage());
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
      //
      if (!$this->CheckUserAccess()) {
        return redirect('/welcome')->withError('E300: This sestion is for SUPER ADMIN only.');
      }
      $rallye = Rallye::find($id);

      return view('rallyes.edit')->with('rallye', $rallye);
    } catch (Exception $e) {
      return Redirect::back()->withError('E137: ' . $e->getMessage());
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
      //
      if (!$this->CheckUserAccess()) {
        return redirect(route('welcome'))->withError('E300: This sestion is for SUPER ADMIN only.');
      }
      $this->validate($request, [
        //Rules to validate
        'title' => 'required'
      ]);

      // update a rallye
      $rallye = Rallye::find($id);
      $rallye->title = $request->input('title');
      $rallye->rallyemail = Str::lower($request->input('rallyemail'));

      $rallye->isPetitRallye = isset($request['isPetitRallye']) ? 1 : 0;
      $rallye->user_id = Auth::user()->id;
      $rallye->save();

      return redirect(route('rallyes'))->with('success', 'M051: Rallye updated');
    } catch (Exception $e) {
      return redirect(route('rallyes'))->withError('E138: ' . $e->getMessage());
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
    try {
      //
      if (!$this->CheckUserAccess()) {
        return redirect('/welcome')->withError('E300: This sestion is for SUPER ADMIN only.');
      }

      // We can delete it if there is no attached applications
      $countEngagements = Application::where('rallye_id', $id)->count();
      // We can delete it if there is no attached groups (Standard or small)
      $countEngagements += Group::where('rallye_id', $id)->count();
      if ($countEngagements == 0) {
        // Deleting the related Rallyes Coordinators
        Coordinator_Rallye::where('rallye_id', $id)->delete();
        Admin_Rallye::where('rallye_id', $id)->delete();
        Rallye::find($id)->delete();

        return redirect(route('rallyes'))->with('success', 'M00: The rally has been deleted.');
      } else {
        return redirect('/rallyes')->withErrors('E301: Please contact your admin/developer to make this action');
      }
    } catch (Exception $e) {
      return redirect(route('rallyes'))->withError('E139: ' . $e->getMessage());
    }
  }
}
