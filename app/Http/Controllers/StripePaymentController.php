<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\Redirect;
use App\Models\Application;
use App\Models\MembershipPrice;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Repositories\EmailRepository;

class StripePaymentController extends Controller
{
  protected $emailRepository;

  public function __construct(EmailRepository $emailRepository)
  {
    $this->emailRepository = $emailRepository;
  }

  /**
   * success response method.
   *
   * @return \Illuminate\Http\Response
   */
  public function stripe()
  {
    return view('stripe');
  }

  public function postPayment()
  {
    return view('stripe.postPayment');
  }

  /**
   * success response method.
   *
   * @return \Illuminate\Http\Response
   */
  public function stripePost(Request $request)
  {

    try {
      $membershipPrice = MembershipPrice::find($request->input('membershipPrice_id'));
      $application = Application::find($request->input('application_id'));
      $paymentDescription = $request->input('paymentDescription');

      if ($application != null) {
        if ($membershipPrice != null) {

          //     Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

          //     $payment = \Stripe\Charge::create([
          //       "amount" => $membershipPrice->mount * 100,
          //       "currency" => config('constants.paymentDetails.currency'),
          //       "source" => $request->stripeToken, // obtained with Stripe.js
          //       "description" => $paymentDescription
          //     ]);

          //     if ($payment == NULL) {
          //       Log::stack(['single', 'stdout'])->error("[STRIPE] : result of Stripe\Charge is empty  ! ");
          //     } else {
          //       Log::stack(['single', 'stdout'])->info("[STRIPE] : Payment Successful for: " . $paymentDescription);
          //     }

          $htmlData = [
            'application' => $application
          ];

          // Your child is transferred from one rallye to another one
          //////////////////////////////////////////////////////////////////////
          // MAIL 04: Payment Confirmation Email (SMTP)
          //////////////////////////////////////////////////////////////////////

          // // Log::stack(['single', 'stdout'])->debug("[STRIPE] : before Mail Sent : paymentConfirmationEmail to");
          Mail::send('mails/paymentConfirmationEmail', $htmlData, function ($m) use ($application) {
            $m->from($application->rallye->rallyemail, env('APP_NAME'));
            $m->replyTo($application->rallye->rallyemail);
            $m->to($application->parentemail);
            $m->subject('[' . env('APP_NAME') . '] - Payment confirmation');
          });

          //////////////////////////////////////////////////////////////////////
          // MAIL 04: Payment Confirmation Email (MailGun)
          //////////////////////////////////////////////////////////////////////
          // $msgdata = array(
          //   'from'        => env('APP_NAME') . '<' . $application->rallye->rallyemail . '>',
          //   'subject'     => '[' . env('APP_NAME') . '] - Payment confirmation',
          //   'to'          => $application->parentlastname . " " . $application->parentfirstname . ' <' . $application->parentemail . '>',
          //   "h:Reply-To"  => $application->rallye->rallyemail,
          // );

          // $html = view('mails/paymentConfirmationEmail', $htmlData)->render();
          // $this->emailRepository->sendMailGun($msgdata, $html);
          //////////////////////////////////////////////////////////////////////

          //Use CheckMailSent to log and check if sending OK
          $this->emailRepository->CheckMailSent($application->parentemail, Mail::failures(), "paymentConfirmationEmail", "Guest");

          Session::flash('success-message', 'Payment done successfully !');
          return redirect('/postPayment');
        } else {
          return Redirect::back()->withError('E229: ' . 'Membership price not found. Please try later on.');
        }
      } else {
        return Redirect::back()->withError('E230: ' . 'Application not found. Please try later on.');
      }
    } catch (Exception $e) {
      Log::stack(['single', 'stdout'])->debug("[EXCEPTION] - [STRIPE] : ca passe  pas ! pour " . $paymentDescription . $e->getMessage());
      return Redirect::back()->withError('E228: ' . $e->getMessage());
    }
  }
}
