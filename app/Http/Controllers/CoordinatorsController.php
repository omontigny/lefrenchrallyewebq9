<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coordinator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use App\Models\Coordinator_Rallye;
use Illuminate\Support\Facades\Config;
use App\Models\Role;
use App\Models\Role_User;
use Illuminate\Support\Facades\DB;
use App\Repositories\EmailRepository;


class CoordinatorsController extends Controller
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
      // Checking if the user is allowed to go here
      if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
        $coordinators = Coordinator::orderBy('lastname', 'asc')->paginate(10);
        $allowed = true;
        return view('coordinators.index')->with('coordinators', $coordinators);
      } else {
        return redirect('/welcome')->withErrors('E004: You are not allowed to visit this URL, please contact your super admin to check your profile role.');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E060: ' . $e->getMessage());
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
      return view('coordinators.create');
    } catch (Exception $e) {
      return Redirect::back()->withError('E061: ' . $e->getMessage());
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
    //
    $this->validate($request, [
      //Rules to validate
      'username' => 'required',
      'lastname' => 'required',
      'firstname' => 'required',
      'mail' => 'required'
    ]);
    try {
      DB::beginTransaction();
      // Creating a coordinator user account
      $user = User::where('email', strtolower($request->input('mail')))->first();
      if ($user == null) {
        // create user
        $user = new User();
        $user->name = strtolower($request->input('username'));
        $userPassword =  $this->emailRepository->generatePassword();
        $user->password = Hash::make($userPassword);
        $user->email = strtolower($request->input('mail'));
        // affecting active_profile to COORDINATOR
        $user->active_profile = config('constants.roles.COORDINATOR');
        $user->coordinator = 2;
        $user->save();

        // create role user
        $role = Role::where('rolename', config('constants.roles.COORDINATOR'))->first();
        $role_user = new Role_User;
        $role_user->role_id  = $role->id;
        $role_user->user_id = $user->id;
        $role_user->save();

        // Add a coordinator
        $coordinator = new  Coordinator;
        $coordinator->username = strtolower($request->input('username'));
        $coordinator->lastname = strtoupper($request->input('lastname'));
        $coordinator->firstname = strtoupper($request->input('firstname'));
        $coordinator->mail = strtolower($request->input('mail'));
        $coordinator->user_id = $user->id;
        $coordinator->save();
        DB::commit();

        $htmlData = [
          'coordinator' => $coordinator,
          'userPassword' => $userPassword
        ];

        //////////////////////////////////////////////////////////////////////
        // MAIL 09: Coordinator Password Reset (welcome) (SMTP)
        //////////////////////////////////////////////////////////////////////

        // $bcclist =  $coordinator->mail;
        // $bccnamelist = $coordinator->firstname;
        // $bcclistmails = array('bccnamelist' => $bcclist);

        Mail::send('mails/CoordinatorPasswordReset', $htmlData, function ($m) use ($coordinator) {
          $m->from(env('MAIL_ADMIN_ADDRESS'), env('APP_NAME'));
          $m->replyTo(env('MAIL_ADMIN_ADDRESS'));
          $m->to($coordinator->mail);
          $m->subject('[' . env('APP_NAME') . '] - Welcome dear coordinator');
        });

        //////////////////////////////////////////////////////////////////////
        // MAIL 09: Coordinator Password Reset (welcome) (MailGun)
        //////////////////////////////////////////////////////////////////////
        // $msgdata = array(
        //   'from'        => env('APP_NAME') . '<' . env('MAIL_ADMIN_ADDRESS') . '>',
        //   'subject'     => '[' . env('APP_NAME') . '] - Welcome dear Coordinator',
        //   'to'          => $coordinator->lastname . " " . $coordinator->firstname . ' <' . $coordinator->mail . '>',
        //   "h:Reply-To"  => env('MAIL_ADMIN_ADDRESS'),
        // );

        // $html = view('mails/CoordinatorPasswordReset', $htmlData)->render();
        // $this->emailRepository->sendMailGun($msgdata, $html);
        //////////////////////////////////////////////////////////////////////

        //Use CheckMailSent to log and check if sending OK
        $this->emailRepository->CheckMailSent($coordinator->mail, Mail::failures(), "CoordinatorPasswordReset", Auth::user()->name);

        return redirect('/coordinators')->with('success', 'M018: A coordinator has been added');
      } else {

        // check if user bas already parent role
        $roleCr = Role::where('rolename', config('constants.roles.COORDINATOR'))->first();
        $role_user = Role_User::where('user_id', $user->id)->where('role_id', $roleCr->id)->first();
        if ($role_user == null) {
          // create role user account
          $role = Role::where('rolename', config('constants.roles.COORDINATOR'))->first();
          $role_user = new Role_User;
          $role_user->role_id  = $role->id;
          $role_user->user_id = $user->id;
          $role_user->save();
          // $user->active_profile = config('constants.roles.COORDINATOR');
          $user->coordinator = 1;
          $user->save();
          $isNewCoordinator = true;
        } else {
          $isNewCoordinator = false;
          DB::commit();
          return Redirect::back()->withError('E062: ' . strtolower($request->input('mail')) . ' has already has already the coordinator profile!');
        }

        if ($isNewCoordinator) {
          // Add a coordinator
          $coordinator = new  Coordinator;
          $coordinator->username = strtolower($request->input('username'));
          $coordinator->lastname = strtoupper($request->input('lastname'));
          $coordinator->firstname = strtoupper($request->input('firstname'));
          $coordinator->mail = strtolower($request->input('mail'));
          $coordinator->user_id = $user->id;
          $coordinator->save();
          DB::commit();
          return redirect('/home')->with('success', 'M019: A coordinator has been added');
        }
      }
    } catch (Exception $e) {
      DB::rollback();
      return Redirect::back()->withError('E063: ' . $e->getMessage());
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
      $coordinator = Coordinator::find($id);
      return view('coordinators.edit')->with('coordinator', $coordinator);
    } catch (Exception $e) {
      return Redirect::back()->withError('E065: ' . $e->getMessage());
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
      $this->validate($request, [
        //Rules to validate
        'lastname' => 'required',
        'firstname' => 'required',
        'mail' => 'required'
      ]);

      // updating coordinator
      $coordinator = Coordinator::find($id);
      $coordinator->lastname = strtoupper($request->input('lastname'));
      $coordinator->firstname = strtoupper($request->input('firstname'));
      $coordinator->mail = strtolower($request->input('mail'));
      $coordinator->save();

      // updateing coordinator
      $user = User::where('email', strtolower($request->input('mail')))->first();
      if ($user != null) {
        $user->email = strtolower($request->input('mail'));
        $user->save();
      }


      return redirect('/coordinators')->with('success', 'M020: The coordinator has been updated');
    } catch (Exception $e) {
      return Redirect::back()->withError('E066: ' . $e->getMessage());
    }
  }

  public function destroy($id)
  {
    try {
      $coordinator = Coordinator::find($id);
      if ($coordinator != null) {
        $user = User::find($coordinator->user_id);

        $roleCr = Role::where('rolename', config('constants.roles.COORDINATOR'))->first();
        // Deleting User Role (as Coordinator)
        Role_User::where('user_id', $coordinator->user_id)
          ->where('role_id', $roleCr->id)->delete();

        // Deleting coordinator rallyes
        Coordinator_Rallye::where('coordinator_id', $coordinator->id)->delete();

        // Deleting the coordinator

        // Check if user to keep if he plays an other role, else delete it
        $coordinator->delete();
        $user->coordinator = 0;
        $userToKeep = false;
        if ($user->admin == 1 || $user->admin == 2) {
          $user->active_profile = config('constants.roles.SUPERADMIN');
          $user->admin = 2;
          $userToKeep = true;
        } else if ($user->parent == 1 || $user->parent == 2) {
          $user->active_profile = config('constants.roles.PARENT');
          $user->parent = 2;
          $userToKeep = true;
        }
        if ($userToKeep) {
          $user->save();
        } else {
          $user->delete();
        }

        //$user->delete();
        return redirect('/home')->with('success', 'M021: A coordinator has been deleted');
      } else {
        return redirect('/home')->withErrors('E005: There is no coordinator called ' . $request->input('fullname'));
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E067: ' . $e->getMessage());
    }
  }
}
