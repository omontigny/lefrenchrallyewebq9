<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Repositories\EmailRepository;
use App\Models\Application;
use App\Models\Payment;
use App\Models\MembershipPrice;
use Omnipay\Omnipay;
use Exception;

class PaymentController extends Controller
{

  public function __construct(EmailRepository $emailRepository)
  {
    $this->gateway = Omnipay::create('Stripe\PaymentIntents');
    $this->gateway->setApiKey(env('STRIPE_SECRET'));
    $this->completePaymentUrl = route('stripe.confirm');
    $this->emailRepository = $emailRepository;
    $this->currency = config('constants.paymentDetails.currency');
  }
  /**
   * success response method.
   *
   * @return \Illuminate\Http\Response
   */
  public function payment()
  {
    return view('payment.payment');
  }

  public function postPayment()
  {
    return view('payment.postPayment');
  }

  public function edit($id)
  {
    //
    try {
      $application = Application::find($id);
      $membershipPrice = MembershipPrice::where('schoolyear_id', $application->schoolyear_id)
        ->where('is_boarder', $application->is_boarder)
        ->get()
        ->first();

      Log::stack(['single'])->debug("[STRIPE] : Je suis dans Stripe/edit pour initier le PaymentIntent");
      Log::stack(['single'])->debug("[STRIPE] : membershipPrice" . $membershipPrice);

      $paymentDescription = $application->id . '# ' . $application->childfirstname . ' / ' . $application->parentfirstname . ' ' . $application->parentlastname . ' (Price: ' . $membershipPrice->mount . ' GBP - Rallye: ' . $application->rallye->title . ')';
      Log::stack(['single'])->debug("[STRIPE] Payment Description:" . $paymentDescription);

      $payment = Payment::where('application_id', $application->id)->get()->first();
      if ($payment != null && $payment->payment_status == "succeeded") {
        return Redirect::back()->withSuccess('E255: ' . "You already paid your membership");
      }

      $data = [
        'application'     => $application,
        'membershipPrice' => $membershipPrice,
        'description'     => $paymentDescription
      ];
      return view('payment.payment')->with($data);
    } catch (Exception $e) {
      Log::stack(['single'])->error("[EXCEPTION] - [Stripe] : ça passe  pas !" .  $e->getMessage());
      return Redirect::back()->withError('E230: ' . $e->getMessage());
    }
  }

  public function charge(Request $request)
  {
    try {
      if ($request->input('stripeToken')) {

        $membershipPrice = $request->input('membershipPrice');
        $application = Application::find($request->input('application_id'));
        $paymentDescription = $request->input('paymentDescription');
        $customerName = $request->input('cardholder-name');
        $token = $request->input('stripeToken');
        $metadata = ['name' => $customerName, 'email' => $application->parentemail];
        // en JS
        // stripe.handleCardPayment(
        //           paymentIntent.client_secret, cardElement, {
        //               payment_method_data: {
        //                   billing_details: {name: cardholderName.value}
        //               }
        //           }
        $response = $this->gateway->authorize([
          'amount'      => $membershipPrice,
          'currency'    => $this->currency,
          'description' => $paymentDescription,
          'token'       => $token,
          'metadata'    => $metadata,
          'returnUrl'   => $this->completePaymentUrl,
          'confirm'     => true,
        ])->send();

        if ($response->isSuccessful()) {

          $response = $this->gateway->capture([
            'amount'    => $membershipPrice,
            'currency'  => $this->currency,
            'paymentIntentReference' => $response->getPaymentIntentReference(),
          ])->send();

          $arr_payment_data = $response->getData();

          $this->store_payment([
            'payment_id'     => $arr_payment_data['id'],
            'application_id' => $application->id,
            'rallye_id'      => $application->rallye->id,
            'payer_email'    => $application->parentemail,
            'amount'         => $arr_payment_data['amount'] / 100,
            'currency'       => $this->currency,
            'description'    => $paymentDescription,
            'payment_status' => $arr_payment_data['status'],
          ]);

          return redirect("/postPayment")->with("success", "Payment done successfully !");
        } elseif ($response->isRedirect()) {
          session(['payer_email'    => $application->parentemail]);
          session(['application_id' => $application->id]);
          session(['description'    => $paymentDescription]);
          session(['rallye_id'      => $application->rallye->id]);
          $response->redirect();
        } else {
          return Redirect::back()->withError('E231: ' . $response->getMessage());
        }
      }
    } catch (Exception $e) {
      Log::stack(['single'])->error("[EXCEPTION] - [STRIPE - Charge] : ca passe  pas ! pour " . $paymentDescription . $e->getMessage());
      return Redirect::back()->withError('E231: ' . $e->getMessage());
    }
  }

  public function Confirm(Request $request)
  {
    try {
      $response = $this->gateway->confirm([
        'paymentIntentReference' => $request->input('payment_intent'),
        'returnUrl' => $this->completePaymentUrl,
      ])->send();

      if ($response->isSuccessful()) {
        $metadata = ['step' => "capture confirm"];

        $response = $this->gateway->capture([
          'amount'      => session('amount'),
          'metadata'  => $metadata,
          'currency'    => $this->currency,
          'paymentIntentReference' => $request->input('payment_intent'),
        ])->send();

        # payment_method_data: { billing_details: {name: cardholderName},
        $arr_payment_data = $response->getData();



        $this->store_payment([
          'payment_id'     => $arr_payment_data['id'],
          'application_id' => session('application_id'),
          'rallye_id'      => session('rallye_id'),
          'payer_email'    => session('payer_email'),
          'amount'         => $arr_payment_data['amount'] / 100,
          'currency'       => $this->currency,
          'description'    => session('description'),
          'payment_status' => $arr_payment_data['status'],
        ]);

        return redirect("/postPayment")->with("success", "Payment done successfully !");
      } else if ($response->isRedirect()) {
        $response->redirect();
      } else {
        Log::stack(['single'])->error("[EXCEPTION] - [STRIPE] : Confirmation not completed: " . $response->getMessage());
        return Redirect::back()->withWarning('W232: ' . $response->getMessage());
      }
    } catch (Exception $e) {
      Log::stack(['single'])->error("[EXCEPTION] - [STRIPE - confirm] : ca passe  pas ! pour " . session('description') . $e->getMessage());
      return Redirect::back()->withError('E232: ' . $e->getMessage());
    }
  }

  public function store_payment($arr_data = [])
  {
    try {
      $isPaymentExist = Payment::where('payment_id', $arr_data['payment_id'])->first();
      $payment = Payment::where('application_id', $arr_data['application_id'])->get()->first();

      if ($payment != null && $payment->payment_status == "succeeded") {
        return Redirect::back()->with('success', 'I002: Thank you, you already paid your membership.');
      }

      if (!$isPaymentExist) {
        $payment = new Payment;
        $payment->payment_id     = $arr_data['payment_id'];
        $payment->application_id = $arr_data['application_id'];
        $payment->rallye_id      = $arr_data['rallye_id'];
        $payment->payer_email    = $arr_data['payer_email'];
        $payment->amount         = $arr_data['amount'];
        $payment->currency       = $this->currency;
        $payment->description    = $arr_data['description'];
        $payment->payment_status = $arr_data['payment_status'];
        $payment->save();

        $application = Application::find($arr_data['application_id']);

        $htmlData = [
          'application' => $application
        ];

        //////////////////////////////////////////////////////////////////////
        // MAIL 04: Payment Confirmation Email (SMTP)
        //////////////////////////////////////////////////////////////////////

        // // Log::stack(['single', 'single'])->debug("[STRIPE] : before Mail Sent : paymentConfirmationEmail to");
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
        $this->emailRepository->CheckMailSent($application->parentemail, Mail::flushMacros(), "paymentConfirmationEmail", "Guest");

        Session::flash('success-message', 'Payment done successfully !');
        return redirect('/postPayment');
      }
      return Redirect::back()->withError('E234: ' . "Payment not completed - Please retry");
    } catch (Exception $e) {
      Log::stack(['single'])->error("[EXCEPTION] - [STRIPE] : ca passe  pas ! pour " . $arr_data['description'] . $e->getMessage());
      return Redirect::back()->withError('E235: ' . $e->getMessage());
    }
  }
}
