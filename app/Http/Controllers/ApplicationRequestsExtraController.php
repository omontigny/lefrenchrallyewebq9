<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Models\Application;
use App\Models\CheckIn;
use App\Models\Parents;
use App\Models\Children;
use App\Models\Role_User;
use App\Models\Role;
use App\Models\Invitation;
use App\User;
use App\Models\Parent_Rallye;
use Illuminate\Http\Request;
use App\Models\KeyValue;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Repositories\EmailRepository;

class ApplicationRequestsExtraController extends Controller
{
  protected $emailRepository;

  public function __construct(EmailRepository $emailRepository)
  {
    // if user is not identified, he will be redirected to the login page
    $this->middleware('auth');
    $this->emailRepository = $emailRepository;
  }

  public function ActivateMailto($id)
  {
    $application = Application::find($id);
    $application->mailto = ($application->mailto == 0) ? 1 : 0;
    $application->save();
    return Redirect::back();
  }


  //
  public function acceptAllApplications()
  {
    try {
      $applications = Application::all();
      foreach ($applications as $application) {
        // 0: Initialized
        if ($application->status != 1) {
          // 1: approved
          $application->status = 1;
          // parent can not update his request/must done by coordinator
          $application->submitted = true;
          //$application->approvedby = Auth::user();
          $application->save();
        }
      }

      return redirect('/applicationrequests')->with('success', 'M007: All applications have been accepted');
    } catch (Exception $e) {
      return Redirect::back()->withError('E040: ' . $e->getMessage());
    }
  }

  public function rejectAllApplications()
  {
    $applications = Application::all();
    foreach ($applications as $application) {
      // 9: rejected
      $application->status = 9;
      //$application->approvedby = Auth::user();
      $application->save();
    }

    return redirect('/applicationrequests')->with('success', 'M008: All applications have been rejected');
  }

  public function deleteAllApplications()
  {
    try {
      Application::getQuery()->delete();

      $applications = Application::all();

      $data = [
        'rallyes'  => $applications,
        'success'   => 'Irreversible delete has done successuflly!'
      ];

      return redirect()->route('applicationrequests.index')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E041: ' . $e->getMessage());
    }
  }

  public function approveApplicationById($id)
  {
    DB::beginTransaction();

    try {

      // to manage parent creation
      $isNewParent = false;

      $application = Application::find($id);

      // parent can not update his request/must done by coordinator
      $application->submitted = true;
      // check if user already exists by its email
      $user = User::where('email', strtolower($application->parentemail))->first();
      $userPassword = '';
      Log::stack(['single', 'stdout'])->debug("userpassword: " . $userPassword);

      if ($user == null) {
        // create user account
        $user = new User();
        $user->name = strtoupper($application->parentlastname);
        $user->password = '$2y$10$';
      }

      Log::stack(['single', 'stdout'])->debug("user id exist? : " . $user->id);
      $user->email = strtolower($application->parentemail);
      $user->save();

      // affecting active_profile to PARENT
      if ($user->admin == 2 ||  $user->coordinator == 2) {
        $user->parent = 1;
      } else {
        $user->parent = 2;
        $user->active_profile = config('constants.roles.PARENT');
      }
      $user->save();

      // check if user bas already parent role
      $roleCr = Role::where('rolename', config('constants.roles.PARENT'))->first();
      $role_user = Role_User::where('user_id', $user->id)->where('role_id', $roleCr->id)->first();
      $parent = null;
      if ($role_user == null) {
        // create role user account
        $role = Role::where('rolename', config('constants.roles.PARENT'))->first();
        $role_user = new Role_User;
        $role_user->role_id  = $role->id;
        $role_user->user_id = $user->id;
        $role_user->save();
        $isNewParent = true;
      } else {
        $isNewParent = false;
      }

      if ($isNewParent) {
        // parent info
        $parent = new Parents();
        $parent->parentfirstname  = ucfirst($application->parentfirstname);
        $parent->parentlastname      = strtoupper($application->parentlastname);
        $parent->parentaddress    = strtoupper($application->parentaddress);
        $parent->parenthomephone  = $application->parenthomephone;
        $parent->parentmobile     = $application->parentmobile;
        $parent->parentemail        = strtolower($application->parentemail);
        $parent->user_id            = $user->id;
        $parent->save();
      } else {
        $parent = Parents::where('user_id', $user->id)->get()->first();
      }

      // child info
      $child =  new Children();
      $child->childfirstname  = ucfirst($application->childfirstname);
      $child->childlastname   = strtoupper($application->childlastname);
      $child->childbirthdate  = $application->childbirthdate;
      $child->childgender     = strtoupper($application->childgender);
      $child->childemail      = strtolower($application->childemail);
      $child->childphotopath  = $application->childphotopath;
      $child->rallye_id       = $application->rallye_id;
      $child->parent_id       = $parent->id;
      $child->application_id   = $application->id;
      $child->save();

      // Check if there is any events for the choosen rallye and adding child to their checkin lists
      if (!$application->rallye->isPetitRallye) {
        $invitations = Invitation::where('rallye_id', $child->rallye_id)->get();
        if (count($invitations) > 0) {
          foreach ($invitations as $invitation) {
            // creating checkin for all invitations
            if ($invitation->group->rallye->id == $application->rallye_id) {
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

      // 1: membered (Petit Rallye)
      // 4: Approved (Standard Rallye)
      if ($application->rallye->isPetitRallye) {
        $application->status = 1;

        // Reset password only if user password is the default one
        if ($user->password == "$2y$10$") {
          $userPassword = $this->emailRepository->generatePassword();
          $user->password = Hash::make($userPassword);
          $user->save();
        }

        $domainLink = $this->emailRepository->getKeyValue('OFFICIAL_LINK');

        //////////////////////////////////////////////////////////////////////
        // MAIL 05: Membership Confirmed Small Rallye (SMTP)
        //////////////////////////////////////////////////////////////////////

        $data = [
          'application' => $application,
          'userPassword' => $userPassword,
          'domainLink' => $domainLink
        ];

        // Sending Membership confirmed email
        Mail::send('mails/membershipConfirmedEmail', $data, function ($m) use ($application) {
          $m->from($application->rallye->rallyemail, env('APP_NAME'));
          $m->replyTo($application->rallye->rallyemail);
          $m->to($application->parentemail);
          $m->subject('[' . env('APP_NAME') . '] - Membership confirmed Small Rallye');
        });

        //////////////////////////////////////////////////////////////////////
        // MAIL 05: Membership Confirmed Small Rallye (MailGun)
        //////////////////////////////////////////////////////////////////////
        // $msgdata = array(
        //   'from'        => env('APP_NAME') . '<' . $application->rallye->rallyemail . '>',
        //   'subject'     => '[' . env('APP_NAME') . '] - Membership confirmed Small Rallye',
        //   'to'          => $application->parentlastname . " " . $application->parentfirstname . ' <' . $application->parentemail . '>',
        //   "h:Reply-To"  => $application->rallye->rallyemail,
        // );

        // $htmlData = array(
        //   'application' => $application,
        //   'userPassword' => $userPassword,
        //   'domainLink' => $domainLink
        // );

        // $html = view('mails/membershipConfirmedEmail', $htmlData)->render();
        // $this->emailRepository->sendMailGun($msgdata, $html);
        //////////////////////////////////////////////////////////////////////

        //Use CheckMailSent to log and check if sending OK
        $this->emailRepository->CheckMailSent($application->childfirstname, Mail::failures(), "membershipConfirmedEmail", Auth::user()->name);
      } else {
        $application->status = 4;
        $application->mailto = 1;

        // $key = 'PAYMENT_LINK';
        // $keyValue = KeyValue::where('key', $key)->first();
        // $paymentLink = ($keyValue != null) ? $keyValue->value : $key;
        $paymentLink = $this->emailRepository->getKeyValue('PAYMENT_LINK');

        // $key = 'DOMAIN_LINK';
        // $keyValue = KeyValue::where('key', $key)->first();
        // $domainLink = ($keyValue != null) ? $keyValue->value : $key;
        $domainLink = $this->emailRepository->getKeyValue('DOMAIN_LINK');

        //////////////////////////////////////////////////////////////////////
        // MAIL 02: Acceptance Email (SMTP)
        //////////////////////////////////////////////////////////////////////
        $data = [
          'application' => $application,
          'paymentLink' => $paymentLink,
          'domainLink' => $domainLink
        ];

        Mail::send('mails/acceptanceEmail', $data, function ($m) use ($application) {
          $m->from($application->rallye->rallyemail, env('APP_NAME'));
          $m->replyTo($application->rallye->rallyemail);
          $m->to($application->parentemail, $application->parentfirstname)
            ->subject('[' . env('APP_NAME') . '] - Acceptance email');
        });

        //////////////////////////////////////////////////////////////////////
        // MAIL 02: Acceptance Email (MailGun)
        //////////////////////////////////////////////////////////////////////
        // $msgdata = array(
        //   'from'        => env('APP_NAME') . '<' . $application->rallye->rallyemail . '>',
        //   'subject'     => '[' . env('APP_NAME') . '] - Acceptance email',
        //   'to'          => $application->parentlastname . " " . $application->parentfirstname . ' <' . $application->parentemail . '>',
        //   "h:Reply-To"  => $application->rallye->rallyemail,
        // );

        // $htmlData = array(
        //   'application' => $application,
        //   'paymentLink' => $paymentLink,
        //   'domainLink'  => $domainLink,
        // );

        // $html = view('mails/acceptanceEmail', $htmlData)->render();
        // $this->emailRepository->sendMailGun($msgdata, $html);
        //////////////////////////////////////////////////////////////////////

        //Use CheckMailSent to log and check if sending OK
        $this->emailRepository->CheckMailSent($application->parentemail, Mail::failures(), "acceptanceEmail", Auth::user()->name);
      }

      $application->parent_id = $parent->id;
      //$application->approvedby = Auth::user();
      $application->save();

      //Parent_Rallye
      //$parentRallyeDB = Parent_Rallye::where('parent_id', $parent->id)->where('rallye_id', $application->rallye_id)->first();
      $parentRallyeDB = Parent_Rallye::where('parent_id', $parent->id)->first();
      $parentRallye = new Parent_Rallye();
      $parentRallye->rallye_id = $application->rallye_id;
      $parentRallye->parent_id = $parent->id;
      $parentRallye->active_rallye = ($parentRallyeDB == null) ? '1' : '0';
      $parentRallye->application_id = $application->id;
      $parentRallye->save();

      DB::commit();


      return redirect('/applicationrequests')->with('success', 'M009: The application has been approved');
    } catch (Exception $e) {
      DB::rollback();
      return Redirect::back()->withError('E042: ' . $e->getMessage());
    }
  }

  public function ResetParentPassword(Request $request)
  {
    DB::beginTransaction();
    try {
      $application = Application::find($request->input('application_id'));

      if ($application != null) {
        $child = Children::where('application_id', $application->id)->get()->first();
        $parent = Parents::find($child->parent_id);
        $user = User::find($parent->user_id);
        $userPassword = $this->emailRepository->generatePassword();
        $user->password = Hash::make($userPassword);
        $user->save();

        //////////////////////////////////////////////////////////////////////
        // MAIL 10: Parent Password Reset (SMTP)
        //////////////////////////////////////////////////////////////////////

        $data = [
          'application' => $application,
          'userPassword' => $userPassword
        ];

        $bcclist =  $application->parentemail;
        $bccnamelist = $application->parentfirstname;
        $bcclistmails = ['bccnamelist' => $bcclist];

        Mail::send('mails/parentPasswordReset', $data, function ($m) use ($application, $bcclistmails) {
          $m->from($application->rallye->rallyemail, env('APP_NAME'));
          $m->replyTo($application->rallye->rallyemail);
          $m->to($application->parentemail);
          $m->subject('[' . env('APP_NAME') . '] - Password reset');
        });

        //////////////////////////////////////////////////////////////////////
        // MAIL 10: Parent Password Reset (MailGun)
        //////////////////////////////////////////////////////////////////////
        // $msgdata = array(
        //   'from'        => env('APP_NAME') . '<' . $application->rallye->rallyemail . '>',
        //   'subject'     => '[' . env('APP_NAME') . '] - Password reset',
        //   'to'          => $application->parentlastname . " " . $application->parentfirstname . ' <' . $application->parentemail . '>',
        //   "h:Reply-To"  => $application->rallye->rallyemail,
        // );

        // $htmlData = array(
        //   'application'  => $application,
        //   'userPassword' => $userPassword,
        // );

        // $html = view('mails/parentPasswordReset', $htmlData)->render();
        // $this->emailRepository->sendMailGun($msgdata, $html);
        //////////////////////////////////////////////////////////////////////

        //Use CheckMailSent to log and check if sending OK
        $this->emailRepository->CheckMailSent($application->childfirstname, Mail::failures(), "parentPasswordReset", Auth::user()->name);
      }
      DB::commit();
      return Redirect::back()->with('success', 'M074: The password has been reset successfully.');
    } catch (Exception $e) {
      DB::rollback();
      return Redirect::back()->withError('E197: ' . $e->getMessage());
    }
  }

  public function blockingApplicationById($id)
  {
    try {
      $application = Application::find($id);
      $application->previous_status = $application->status;
      $application->status = 9;
      // parent can not update his request/must done by coordinator
      $application->submitted = true;
      //$application->approvedby = Auth::user();
      $application->save();
      return redirect('/applicationrequests')->with('success', 'M010: The application request has been switch on (blocked status)   ');
    } catch (Exception $e) {
      return Redirect::back()->withError('E043: ' . $e->getMessage());
    }
  }

  public function deBlockingApplicationById($id)
  {
    try {
      $application = Application::find($id);
      $application->status = $application->previous_status;
      // parent can not update his request/must done by coordinator
      //$application->approvedby = Auth::user();
      $application->save();
      return redirect('/applicationrequests')->with('success', 'M011: The application request has been switch on (blocked status)   ');
    } catch (Exception $e) {
      return Redirect::back()->withError('E044: ' . $e->getMessage());
    }
  }

  public function waiteApplicationById($id)
  {
    try {
      $application = Application::find($id);
      if ($application->status == 3) {
        $application->status = $application->previous_status;
      } else {
        $application->previous_status = $application->status;
        $application->status = 3;
      }
      // parent can not update his request/must done by coordinator
      // $application->submitted = true;
      //$application->approvedby = Auth::user();
      $application->save();
      return redirect('/applicationrequests')->with('success', 'M012: The application request >> Waiting status');
    } catch (Exception $e) {
      return Redirect::back()->withError('E045: ' . $e->getMessage());
    }
  }

  public function SendingAcceptanceEmailId($id)
  {
    try {
      $application = Application::find($id);
      $application->status = $application->status;
      //$application->approvedby = Auth::user();
      $application->save();

      return redirect('/applicationrequests')->with('success', 'M013: - The approving email has been sent');
    } catch (Exception $e) {
      return Redirect::back()->withError('E046: ' . $e->getMessage());
    }
  }
}
