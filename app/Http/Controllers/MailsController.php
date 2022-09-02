<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Invitation;
use App\Models\Application;
use App\Models\Group;
use App\Models\CheckIn;
use App\Models\Rallye;
use App\Models\Coordinator;
use App\Models\Admin_Rallye;
use App\Models\Coordinator_Rallye;
use App\Models\Parents;
use App\Models\KeyValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Repositories\EmailRepository;
use App\Repositories\ImageRepository;
use Intervention\Image\Size;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Cloudinary\Cloudinary;
use Symfony\Component\Mime\Email;

class MailsController extends Controller
{

  protected $emailRepository;
  protected $imageRepository;

  public function __construct(EmailRepository $emailRepository, ImageRepository $imageRepository)
  {
    // if user is not identified, he will be redirected to the login page
    $this->middleware('auth');
    $this->emailRepository = $emailRepository;
    $this->imageRepository = $imageRepository;
  }

  public function membershipConfirmedEmail($id)
  {
    try {
      // Loading the application
      $application = Application::find($id);

      // Updating application status.
      $application->status = 1;
      $application->mailto = 0;
      $application->save();

      $parent = Parents::find($application->parent_id);
      $user = User::find($parent->user_id);
      $userPassword = '';
      if ($user->admin == 0 && $user->coordinator == 0) {

        // Check if the parent has a member applicationrequest.
        $activeApplication = Application::where('parent_id', $parent->id)
          ->where('status', 1)->first();

        // Log::stack(['single'])->debug("Parent activeApplication? " . $activeApplication);

        // We generate a new password only if there is no application in progress or if the user has no passwords
        // the password value : "$2y$10$", is the default one where the user is created first shot.
        // If the user already has a password, it's not necessary to reset it
        if ($activeApplication == null || $user->password == "$2y$10$") {
          Log::stack(['single'])->debug("updating user Password");
          //updating parent DefaultPassword
          $userPassword = $this->emailRepository->generatePassword();
          $user->password = Hash::make($userPassword);
          $user->save();
        }
        if ($user->blocked_at) { # Si le compte avait ete desactive on le re-active
          $user->blocked_at = null;
        }
        $user->save();
      }

      $domainLink = $this->emailRepository->getKeyValue('OFFICIAL_LINK');

      $htmlData = [
        'application'  => $application,
        'userPassword' => $userPassword,
        'domainLink'   => $domainLink,
      ];

      if ($application != null) {

        //////////////////////////////////////////////////////////////////////
        // MAIL 05b: Membership confirmed Std Rallye (SMTP)
        //////////////////////////////////////////////////////////////////////

        Mail::send('mails/membershipConfirmedEmail', $htmlData, function ($m) use ($application) {
          $m->from($application->rallye->rallyemail, env('APP_NAME'));
          $m->replyTo($application->rallye->rallyemail);
          $m->to($application->parentemail);
          $m->subject('[' . env('APP_NAME') . '] - Membership Confirmed');
        });

        //////////////////////////////////////////////////////////////////////
        // MAIL 05b: Membership confirmed Std Rallye (MailGun)
        //////////////////////////////////////////////////////////////////////
        // $msgdata = array(
        //   'from'        => env('APP_NAME') . '<' . $application->rallye->rallyemail . '>',
        //   'subject'     => '[' . env('APP_NAME') . '] - Membership Confirmed',
        //   'to'          => $application->parentlastname . " " . $application->parentfirstname . ' <' . $application->parentemail . '>',
        //   "h:Reply-To"  => $application->rallye->rallyemail,
        // );

        // $html = view('mails/membershipConfirmedEmail', $htmlData)->render();
        // $this->emailRepository->sendMailGun($msgdata, $html);
        //////////////////////////////////////////////////////////////////////

        //Use CheckMailSent to log and check if sending OK
        $this->emailRepository->CheckMailSent($application->childfirstname, Mail::flushMacros(), "membershipConfirmedEmail", Auth::user()->name);
      } else {
        return Redirect::back()->withError('E208: No application is found.');
      }
      return Redirect::back()->with('success', 'M077: The membership confirmed mail has been sent successfully.');
    } catch (Exception $e) {
      return Redirect::back()->withError('E209: ' . $e->getMessage());
    }
  }

  public function paymentReminderEmail()
  {
    DB::beginTransaction();
    try {
      $data = null;
      $applications = null;
      // active user is a coordinator
      if (Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {
        // 1. Get active rallye
        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
        if ($coordinator != null) {
          $coordinatorRallye = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
            ->where('active_rallye', '1')->first();
          if ($coordinatorRallye->rallye->isPetitRallye) {
            return Redirect::back()->withError('E207: The active rallye is a "Small one".');
          }

          // 2. Get applications in the active rallye those are in the waiting list(Status = 3)
          $applications = Application::where('rallye_id', $coordinatorRallye->rallye->id)
            ->where('status', '4')->where('mailto', '1')->get();
        }
      }

      // 3. if applications found, send an email to each parent.
      if (count($applications) > 0) {
        // $key = 'PAYMENT_LINK';
        // $keyValue = KeyValue::where('key', $key)->first();
        // $paymentLink = ($keyValue != null) ? $keyValue->value : $key;
        $paymentLink = $this->emailRepository->getKeyValue('PAYMENT_LINK');

        // Sending the reminder paiement email to each parent/child
        foreach ($applications as $application) {

          Log::stack(['single'])->debug("PaymentReminder for: " . $application->parentemail);

          $htmlData = [
            'application' => $application,
            'paymentLink' => $paymentLink
          ];

          //////////////////////////////////////////////////////////////////////
          // MAIL 03: Payment Reminder (SMTP)
          //////////////////////////////////////////////////////////////////////

          Mail::send('mails/paymentReminderEmail', $htmlData, function ($m) use ($application) {
            $m->from($application->rallye->rallyemail, env('APP_NAME'));
            $m->replyTo($application->rallye->rallyemail);
            $m->to($application->parentemail);
            $m->subject('[' . env('APP_NAME') . '] - Payment Reminder');
          });

          //////////////////////////////////////////////////////////////////////
          // MAIL 03: Payment Reminder (MailGun)
          //////////////////////////////////////////////////////////////////////
          // $data = array(
          //   'from'        => env('APP_NAME') . '<' . $application->rallye->rallyemail . '>',
          //   'subject'     => '[' . env('APP_NAME') . '] - Payment Reminder',
          //   'to'          => $application->parentlastname . " " . $application->parentfirstname . ' <' . $application->parentemail . '>',
          //   "h:Reply-To"  => $application->rallye->rallyemail,
          // );

          // $html = view('mails/paymentReminderEmail', $htmlData)->render();
          // $this->emailRepository->sendMailGun($data, $html);
          //////////////////////////////////////////////////////////////////////

          //Use CheckMailSent to log and check if sending OK
          $this->emailRepository->CheckMailSent($application->parentemail, Mail::flushMacros(), "paymentReminderEmail", Auth::user()->name);
        }
        DB::commit();
        return Redirect::back()->with('success', 'M076: The payment reminder mail has been sent successfully.');
      } else {
        DB::rollback();
        return Redirect::back()->withError('E203:  - There is no application that is concerned by the payment reminder.');
      }
    } catch (Exception $e) {
      DB::rollback();
      return Redirect::back()->withError('E196: ' . $e->getMessage());
    }
  }


  public function waitingListEmail()
  {
    try {
      $data = null;
      $applications = [];
      $rallyesID = [];


      // TODO: active user is a admin


      // active user is a coordinator
      if (Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {
        // 1. Get active rallye
        $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
        if ($coordinator != null) {
          $coordinatorRallye = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
            ->where('active_rallye', '1')->first();

          // 2. Get applications in the active rallye those are in the waiting list(Status = 3)
          $applications = Application::where('rallye_id', $coordinatorRallye->rallye->id)->where('status', '3')
            ->get();
        }
      }

      // 3. if applications found, send an email to each parent.
      if (count($applications) > 0) {

        // Sending the waiting list email to each parent/child
        foreach ($applications as $application) {
          $htmlData = [
            'application' => $application,
          ];

          //////////////////////////////////////////////////////////////////////
          // MAIL 06: Waiting List (SMTP)
          //////////////////////////////////////////////////////////////////////

          Mail::send('mails/waitingListEmail', $htmlData, function ($m) use ($application) {
            $m->from($application->rallye->rallyemail, env('APP_NAME'));
            $m->replyTo($application->rallye->rallyemail);
            $m->to($application->parentemail);
            $m->subject('[' . env('APP_NAME') . '] - Waiting list email');
          });

          //////////////////////////////////////////////////////////////////////
          // MAIL 06: Waiting List (MailGun)
          //////////////////////////////////////////////////////////////////////
          // $data = array(
          //   'from'        => env('APP_NAME') . '<' . $application->rallye->rallyemail . '>',
          //   'subject'     => '[' . env('APP_NAME') . '] - Waiting list email',
          //   'to'          => $application->parentlastname . " " . $application->parentfirstname . ' <' . $application->parentemail . '>',
          //   "h:Reply-To"  => $application->rallye->rallyemail,
          // );

          // $html = view('mails/waitingListEmail', $htmlData)->render();
          // $this->emailRepository->sendMailGun($data, $html);
          //////////////////////////////////////////////////////////////////////

          //Use CheckMailSent to log and check if sending OK
          $this->emailRepository->CheckMailSent($application->parentemail, Mail::flushMacros(), "waitingListEmail", Auth::user()->name);
        }
        return Redirect::back()->with('success', 'M073: You will receive an email test with your event group invitation');
      } else {
        return Redirect::back()->withError('E195:  - You do not belong to any rallye - Or Rallye is empty - Or There is no application on waiting list for the active rallye');
      }
    } catch (Exception $e) {
      return Redirect::back()->withError('E196: ' . $e->getMessage());
    }
  }

  public function sendInvitationToAllRallyeMembers()
  {
  }

  public function sendMailToAllRallyeMembers(Request $request)
  {
    try {
      $body         = $request->input('mail_body');
      $bcclist      = str_replace([' ', ';'], ['', ','], trim($request->input('bcclist')));
      $rallyeEmail  = $request->input('rallyeEmail');
      $subject      = $request->input('subject');
      $bccArrayList = explode(',', $bcclist);

      if ($this->emailRepository->validateEmails($bccArrayList) && count($bccArrayList) > 0) {
        $data = array(
          'body' => $body,
        );

        //////////////////////////////////////////////////////////////////////
        // MAIL 14: Send Mail to All Rallye Members in one shot (SMTP)
        //////////////////////////////////////////////////////////////////////
        ## WITH BCC ###
        Mail::send('mails/sendMailToAllRallyeMembers', $data, function ($m) use ($rallyeEmail, $bccArrayList, $subject, $body) {
          $m->from($rallyeEmail, $_ENV['APP_NAME']);
          $m->replyTo($rallyeEmail);
          $m->to($rallyeEmail)
            ->bcc($bccArrayList)
            ->subject($subject)
            ->html($body);
        });

        //////////////////////////////////////////////////////////////////////
        // MAIL 14: Send Mail to All Rallye Members in one shot (MailGun)
        //////////////////////////////////////////////////////////////////////
        // $data = array(
        //   'from'        => env('APP_NAME') . '<' . $from . '>',
        //   'subject'     => $subject,
        //   'to'          => $rallyeEmail,
        //   "h:Reply-To"  => $rallyeEmail,
        //   'bcc'         => $bccArrayList
        // );

        // $html = view('mails/sendCustomEmails', $htmlData)->render();
        // $this->emailRepository->sendMailGun($data, $html);
        //////////////////////////////////////////////////////////////////////

        //Use CheckMailSent to log and check if sending OK
        $this->emailRepository->CheckMailSent($bccArrayList, Mail::flushMacros(), "sendMailToAllRallyeMembers", Auth::user()->name);


        return Redirect::back()->with('success', 'M032: You will receive an email as all group Members');
      }
    } catch (Exception $e) {
      Log::stack(['single', 'stdout'])->debug("[EXCEPTION] - [MAIL To All Rallye Members] : ça passe  pas !" .  $e->getMessage());
      return Redirect::back()->withError('E198: ' . $e->getMessage());
    }
  }

  public function sendCustomMails(Request $request)
  {
    try {
      $body      = $request->input('mail_body');
      $bcclist   = str_replace([' ', ';'], ['', ','], trim($request->input('bcclist')));
      $tolist    = str_replace([' ', ';'], ['', ','], trim($request->input('to')));
      $from      = $request->input('sender');
      $subject   = $request->input('subject');
      $bcc       = explode(',', $bcclist);
      $to        = explode(',', $tolist);

      if ($this->emailRepository->validateEmails($bcc) && count($bcc) > 0) {
        // foreach ($emails as $parent_email) {
        // }
        $htmlData = [
          'body' => $body,
        ];

        //////////////////////////////////////////////////////////////////////
        // MAIL 13: Custom Email (SMTP)
        //////////////////////////////////////////////////////////////////////

        Mail::send('mails/sendCustomEmails', $htmlData, function ($m) use ($to, $bcc, $from, $subject, $body) {
          $m->from($from, env('APP_NAME'));
          $m->replyTo($from);
          $m->to($to)
            ->bcc($bcc)
            ->subject($subject)
            ->html($body);
        });

        //////////////////////////////////////////////////////////////////////
        // MAIL 13: Custom Email (MailGun)
        //////////////////////////////////////////////////////////////////////
        // $data = array(
        //   'from'        => env('APP_NAME') . '<' . $from . '>',
        //   'subject'     => $subject,
        //   'to'          => $to,
        //   "h:Reply-To"  => $from,
        //   'bcc'         => $bcc
        // );

        // $html = view('mails/sendCustomEmails', $htmlData)->render();
        // $this->emailRepository->sendMailGun($data, $html);
        //////////////////////////////////////////////////////////////////////

        //Use CheckMailSent to log and check if sending OK
        $this->emailRepository->CheckMailSent($tolist, Mail::flushMacros(), "sendCustomEmails", Auth::user()->name);


        return Redirect::back()->with('success', 'M032: You will receive this custom email as all cc recipients');
      }
    } catch (Exception $e) {
      Log::stack(['single'])->debug("[EXCEPTION] - [MAIL Custom] : ça passe  pas !" .  $e->getMessage());
      return Redirect::back()->withError('E197: ' . $e->getMessage());
    }
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
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
    $sentList       = [];
    $emailTempo     = Str::lower(env('EMAIL_TEMPO'));
    $emailsPaquet   = env('EMAIL_PAQUET');
    $emailSleep     = env('EMAIL_SLEEP');

    try {
      $app_ID = Application::find($id);
      $now = new Carbon;
      // Expect one invitation by rallye/group
      $invitation = Invitation::with('group')->where('rallye_id', $app_ID->rallye_id)->where('group_id', $app_ID->event_id)->get()->where('group.eventDate', '>=', $now)
        ->first();
      #$invitation = Invitation::with('group')->where('user_id', $user->id)->get()->where('group.eventDate', '>=', $now)->sortBy('group.eventDate', SORT_REGULAR, false)->first();


      if ($invitation != null) {
        $rallye_name = $this->emailRepository->replaceNameForStoring(Rallye::find($invitation->rallye_id)->title);
        $group_name = "std";
        if (Rallye::find($invitation->rallye_id)->isPetitRallye) {
          $group_name = $this->emailRepository->replaceNameForStoring(Group::find($invitation->group_id)->name);
        }
        $imageInfo          = $this->imageRepository->setImageInfo($invitation, $rallye_name, $group_name);
        $cloudinaryImageUrl = $this->imageRepository->UploadFromImage64($invitation->invitationFile, $invitation->extension, $rallye_name, $group_name, $imageInfo["imagePath"], $imageInfo["imageMetadata"]);


        $imageUrl = URL::asset($imageInfo["imagePath"]);
        Log::stack(['single', 'stdout'])->debug("[MAIL] - imageUrl: " . $imageUrl);
        # Log::stack(['single', 'stdout'])->debug("[MAIL] - cloudinaryImageUrl: " . $cloudinaryImageUrl);

        // CASE 1: PETIT RALLYE
        if ($app_ID->rallye->isPetitRallye) {
          $applications = Application::where('rallye_id', $app_ID->rallye_id)
            ->where('status', 1)
            ->where('group_name', Str::upper($app_ID->group_name))
            ->get();
        } else {
          // CASE 2: RALLYE STANDARD
          $applications = Application::where('rallye_id', $app_ID->rallye_id)
            ->where('status', 1)
            ->get();
        }

        // Sending the invitation to each parent/child
        $application = $applications->first();
        $compteur = 0;
        $countMail = 0;
        $toSendList = "";
        $bccParentNamelist = "";

        Log::stack(['single'])->debug("count:" . count($applications));

        //construction of list emails to send as a unique string
        foreach ($applications as $row) {
          if ($compteur < (count($applications) - 1)) {
            // $toSendList .= "'". $row->parentemail . "',";
            $toSendList .= $row->parentemail . ",";
            $bccParentNamelist .= $row->parentfirstname . ",";
          } else {
            $toSendList .=  $row->parentemail;
            $bccParentNamelist .= $row->parentfirstname . "";
          }
          $compteur++;
        }
        Log::stack(['single'])->debug("Invitation EMail to Send count: " . $compteur);
        Log::stack(['single'])->debug("Invitation EMail to send List: " . $toSendList);
        Log::stack(['single'])->debug("Invitation EMail bccParentNamelist: " . $bccParentNamelist);


        foreach ($applications as $application) {

          $domainLink = $this->emailRepository->getKeyValue('DOMAIN_LINK');
          $htmlData = [
            'app'  => $app_ID,
            'application' => $application,
            'invitation' => $invitation,
            'domainLink' => $domainLink,
            'rallye_name' => $rallye_name,
            'imageName' => $imageInfo["imageName"],
            'invitationFile' => $invitation->invitationFile,
            'imageUrl' => $imageUrl,
            'cloudinaryImageUrl' => $cloudinaryImageUrl
          ];

          //////////////////////////////////////////////////////////////////////
          // MAIL 07: Invitation Email (SMTP)
          //////////////////////////////////////////////////////////////////////

          Mail::send('mails/invitationEmail', $htmlData, function ($m) use ($application) {
            $m->from($application->rallye->rallyemail, env('APP_NAME'));
            $m->replyTo($application->rallye->rallyemail);
            $m->to($application->parentemail, $application->parentfirstname);
            $m->subject('[' . env('APP_NAME') . '] - Invitation email');
          });

          //////////////////////////////////////////////////////////////////////
          // MAIL 07: Invitation Email (Mailgun)
          //////////////////////////////////////////////////////////////////////
          // $data = array(
          //   'from'        => env('APP_NAME') . '<' . $invitation->rallye->rallyemail . '>',
          //   'subject'     => '[' . env('APP_NAME') . '] - Invitation email',
          //   'to'          => $application->parentlastname . " " . $application->parentfirstname . ' <' . $application->parentemail . '>',
          //   "h:Reply-To"  => $invitation->rallye->rallyemail,
          // );

          // $html = view('mails/invitationEmail', $htmlData)->render();
          // $this->emailRepository->sendMailGun($data, $html);
          //////////////////////////////////////////////////////////////////////

          //Use CheckMailSent to log and check if sending OK
          $this->emailRepository->CheckMailSent($application->parentemail, Mail::flushMacros(), "Invitation EMail", Auth::user()->name);

          $countMail++;
          if ($emailTempo === 'true' && $countMail % $emailsPaquet == 0) {
            Log::stack(['single'])->debug("Invitation EMail: paquet: $emailTempo - 1 Paquet de $emailsPaquet mails envoyés => on fait une petite pause de $emailSleep sec");
            sleep($emailSleep);
          }
          array_push($sentList, $application->parentemail);
        }
        Log::stack(['single'])->debug("Invitation EMail Sent count: " . $countMail);
        Log::stack(['single'])->debug("Invitation EMail Sent list: " . implode(";", $sentList));
        Log::stack(['single'])->debug("End Invitation EMail process");

        return Redirect::back()->with('success', 'M033: You will receive an email test with your event group invitation');
      } else {
        return Redirect::back()->withError('E194: No invitation found.');
      }
    } catch (Exception $e) {
      Log::stack(['single'])->error("[EXCEPTION] - [Invitation EMail] : ça passe  pas !" .  $e->getMessage());
      Log::stack(['single'])->error("[EXCEPTION] - [Invitation EMail] : Invitation EMail already Sent list: " . implode(";", $sentList));
      return Redirect::back()->withError('E228: ' . $e->getMessage());
    }
  }

  public function sendInvitationToMyself()
  {
    try {
      $user = User::findOrFail(Auth::user()->id);
      $now = new Carbon;
      $invitation = Invitation::with('group')->where('user_id', $user->id)->get()->where('group.eventDate', '>=', $now)->sortBy('group.eventDate', SORT_REGULAR, false)->first();

      if ($invitation != null) {
        $this->SendInvitationMail($invitation, $user);
        return Redirect::back()->with('success', 'M032: You will receive an email test with your event group invitation');
      } else {
        return Redirect::back()->withError('E082: No invitation to send');
      }
    } catch (Exception $e) {
      Log::stack(['single'])->error("[EXCEPTION] - [Send Invitation to Myself] : ça passe pas !" .  $e->getMessage());
      return Redirect::back()->withError('E229: ' . $e->getMessage());
    }
  }


  public function sendToMyself($id)
  {
    $user = User::findOrFail(Auth::user()->id);
    $invitation = Invitation::find($id);
    Log::stack(['single', 'stdout'])->debug("invitation:  " . $invitation->group->eventDate);
    if ($invitation != null) {
      $this->SendInvitationMail($invitation, $user);
      return Redirect::back()->with('success', 'M032: You will receive an email test with your event group invitation');
    } else {
      return Redirect::back()->withError('E082: No invitation to send');
    }
  }

  public function SendInvitationMail($invitation, $user)
  {
    try {

      $domainLink         = $this->emailRepository->getKeyValue('OFFICIAL_LINK');
      $rallye_name = $this->emailRepository->replaceNameForStoring(Rallye::find($invitation->rallye_id)->title);
      $group_name = "std";
      if (Rallye::find($invitation->rallye_id)->isPetitRallye) {
        $group_name = $this->emailRepository->replaceNameForStoring(Group::find($invitation->group_id)->name);
      }
      $imageInfo          = $this->imageRepository->setImageInfo($invitation, $rallye_name, $group_name);
      $cloudinaryImageUrl = $this->imageRepository->UploadFromImage64($invitation->invitationFile, $invitation->extension, $rallye_name, $group_name, $imageInfo["imagePath"], $imageInfo["imageMetadata"]);

      $imageUrl = URL::asset($imageInfo["imagePath"]);

      $htmlData = [
        'invitation' => $invitation,
        'rallye_name' => $rallye_name,
        'domainLink' => $domainLink,
        'invitationFile' => $invitation->invitationFile,
        'imageName' => $imageInfo["imageName"],
        'imageUrl' => $imageUrl,
        'cloudinaryImageUrl' => $cloudinaryImageUrl
      ];

      //////////////////////////////////////////////////////////////////////
      // MAIL 11: Send Invitation to Myself (SMTP)
      //////////////////////////////////////////////////////////////////////

      Mail::send('mails/sendInvitationToMyself', $htmlData, function ($m) use ($user, $invitation) {
        $m->from($invitation->rallye->rallyemail, env('APP_NAME'));
        $m->replyTo($invitation->rallye->rallyemail);
        $m->to($user->email, $user->name);
        $m->subject('[' . env('APP_NAME') . '] - Send invitation to myself');
      });

      //////////////////////////////////////////////////////////////////////
      // MAIL 11: Send Invitation to Myself (Mailgun)
      //////////////////////////////////////////////////////////////////////
      // $data = array(
      //   'from'        => env('APP_NAME') . '<' . $invitation->rallye->rallyemail . '>',
      //   'subject'     => '[' . env('APP_NAME') . '] - Send invitation to myself',
      //   'to'          => $user->name . ' <' . $user->email . '>',
      //   "h:Reply-To"  => $invitation->rallye->rallyemail,
      // );

      // $html = view('mails/sendInvitationToMyself', $htmlData)->render();
      // $this->emailRepository->sendMailGun($data, $html);
      //////////////////////////////////////////////////////////////////////

      //Use CheckMailSent to log and check if sending OK
      $this->emailRepository->CheckMailSent($user->name, Mail::flushMacros(), "sendInvitationToMyself", Auth::user()->name);
    } catch (Exception $e) {
      Log::stack(['single'])->error("[EXCEPTION] - [Email] : ça passe  pas !" .  $e->getMessage());
      return Redirect::back()->withError('E250: ' . $e->getMessage());
    }
  }


  public function sendTestMail()
  {
    try {
      $from = env('MAIL_ADMIN_ADDRESS');
      if (Auth::user() != null) {
        $user = User::findOrFail(Auth::user()->id);
        if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
          $adminRallye = Admin_Rallye::where('user_id', Auth::user()->id)->where('active_rallye', '1')->first();
          if ($adminRallye != null) {
            $activeRallye = $adminRallye->rallye;
            $from = $activeRallye->rallyemail;
          }
        }
      }

      Log::stack(['single'])->debug("from: " . $from);

      $domainLink = $this->emailRepository->getKeyValue('OFFICIAL_LINK');
      $htmlData = [
        'recipient'  => $user->name,
        'domainLink' => $domainLink,
      ];

      //////////////////////////////////////////////////////////////////////
      // MAIL 14: Control Panel Test Mail (SMTP)
      //////////////////////////////////////////////////////////////////////

      Mail::send('mails/testMail', $htmlData, function ($m) use ($user, $from) {
        $m->from($from, env('APP_NAME'));
        $m->replyTo($from);
        $m->to($user->email, $user->name);
        $m->subject('[' . env('APP_NAME') . '] - Send Test Mail with SMTP');
        // $headers = $m->getHeaders();
        // $headers->addTextHeader('X-Mailgun-Variables', '{"msg_id": "666", "my_campaign_id": 1313}');
        // $headers->addTextHeader('X-Mailgun-Tag', '+33681490182', '+33646124690');
      });

      //////////////////////////////////////////////////////////////////////
      // MAIL 14: Control Panel Test Mail (MailGun)
      //////////////////////////////////////////////////////////////////////

      // $data = array(
      //   'cc'         => "",
      //   'bcc'        => "",
      //   'from'       => $from,
      //   'subject'    => '[' . env('APP_NAME') . '] - Send Test Mail with MailGun',
      //   'to'         => $user->name . '<' . $user->email . '>',
      //   "h:Reply-To" => $activeRallye->rallyemail,
      // );

      // $html = view('mails/testMail', $htmlData)->render();
      // $this->emailRepository->sendMailGun($data, $html);
      //////////////////////////////////////////////////////////////////////

      //Use CheckMailSent to log and check if sending OK
      $this->emailRepository->CheckMailSent($user->name, [], "testMail", Auth::user()->name);

      return Redirect::back()->with('success', 'M033: You will receive a test email');
    } catch (Exception $e) {
      Log::stack(['single'])->error("[EXCEPTION] - [Email] : ça passe  pas !" .  $e->getMessage());
      return Redirect::back()->withError('E229: ' . $e->getMessage());
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

  public function applicationReceivedMail()
  {
  }
  public function acceptanceInStdRallyeMail()
  {
  }
  public function paymentReminderInStdRallyeMail()
  {
  }
  public function membershipConfirmedInStdRallyeMail()
  {
  }
  public function membershipConfirmedInPtRallyeMail()
  {
  }
  public function invitationMail()
  {
  }
}
