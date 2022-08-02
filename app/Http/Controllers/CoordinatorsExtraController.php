<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\Role_User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Repositories\EmailRepository;

class CoordinatorsExtraController extends Controller
{
  protected $emailRepository;

  public function __construct(EmailRepository $emailRepository)
  {
    // if user is not identified, he will be redirected to the login page
    $this->middleware('auth');
    $this->emailRepository = $emailRepository;
  }

  public function superAdmin()
  {
    $userRoles = Role_User::where('user_id', Auth::user()->id)->get();
    $found = false;
    foreach ($userRoles as $usrRoles) {
      if ($userRoles->role->rolename == config('constants.roles.SUPERADMIN')) {
        $found = true;
        break;
      }
    }
    if (!$found) {
      $newRole = new Role_User();
    }
  }

  public function deleteAllCoordinators()
  {
    Coordinator::getQuery()->delete();
    $coordinators = Coordinator::all();

    $data = [
      'coordinators'  => $coordinators,
      'success'   => 'Irreversible delete has done successuflly!'
    ];

    return to_route('coordinators.index')->with($data);
  }

  public function resetCoordinatorPasswordById($id)
  {
    $coordinator = Coordinator::find($id);
    $user = User::find($coordinator->user->id);
    $userPassword =  $this->emailRepository->generatePassword();
    $user->password = Hash::make($userPassword);
    $user->save();
    $coordinator->save();

    $htmlData = [
      'coordinator' => $coordinator,
      'userPassword' => $userPassword
    ];

    //////////////////////////////////////////////////////////////////////
    // MAIL 09b: Coordinator Password Reset (SMTP)
    //////////////////////////////////////////////////////////////////////

    // $bcclist =  $coordinator->mail;
    // $bccnamelist = $coordinator->firstname;
    // $bcclistmails = array('bccnamelist' => $bcclist);

    Mail::send('mails/CoordinatorPasswordReset', $htmlData, function ($m) use ($coordinator) {
      $m->from(env('MAIL_ADMIN_ADDRESS'), env('APP_NAME'));
      $m->replyTo(env('MAIL_ADMIN_ADDRESS'));
      $m->to($coordinator->mail);
      $m->subject('[' . env('APP_NAME') . '] - Coordinator PWD reset');
    });

    //////////////////////////////////////////////////////////////////////
    // MAIL 09b: Coordinator Password Reset (MailGun)
    //////////////////////////////////////////////////////////////////////
    // $msgdata = array(
    //   'from'        => env('MAIL_ADMIN_ADDRESS'),
    //   'subject'     => '[' . env('APP_NAME') . '] - Coordinator PWD reset',
    //   'to'          => $coordinator->name . ' <' . $coordinator->mail . '>',
    //   "h:Reply-To"  => env('MAIL_ADMIN_ADDRESS'),
    // );

    // $html = view('mails/CoordinatorPasswordReset', $htmlData)->render();
    // $this->emailRepository->sendMailGun($msgdata, $html);
    //////////////////////////////////////////////////////////////////////

    //Use CheckMailSent to log and check if sending OK
    $this->emailRepository->CheckMailSent($coordinator->mail, Mail::flushMacros(), "CoordinatorPasswordReset", Auth::user()->name);
    return redirect('/coordinators')->with('success', 'M022: The coordinator password has been reset');
  }

  public function getCoordinar()
  {
    $coordinators = Coordinator::all();
    foreach ($coordinators as $coordinator) {
      $coordinator->status = 0;
      $coordinator->user->password = Hash::make($coordinator->user->lastname . now()->year);
      $coordinator->save();
    }

    return redirect('/coordinators')->with('success', 'M023: The password of each coordinator has been reset');
  }


  public function resetCoordinatorsPassword()
  {
    $coordinators = Coordinator::all();
    foreach ($coordinators as $coordinator) {
      $coordinator->status = 0;
      $coordinator->user->password = Hash::make($coordinator->user->lastname . now()->year);
      $coordinator->save();
    }

    return redirect('/coordinators')->with('success', 'M024: The password of each coordinator has been reset');
  }
}
