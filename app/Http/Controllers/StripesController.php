<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe;
use Exception;
use Illuminate\Support\Facades\Redirect;
use App\Models\Application;
use App\Models\MembershipPrice;
use Illuminate\Support\Facades\Log;

class StripesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
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
    try {
      $application = Application::find($id);
      $membershipPrice = MembershipPrice::where('schoolyear_id', $application->schoolyear_id)
        ->where('is_boarder', $application->is_boarder)
        ->get()
        ->first();

      Log::stack(['single'])->debug("[STRIPE] : Je suis dans Stripe/edit pour initier le PaymentIntent");
      Log::stack(['single'])->debug("[STRIPE] : membershipPrice" . $membershipPrice);

      #$membershipPrice = MembershipPrice::find($request->input('membershipPrice_id'));
      #$application = Application::find($request->input('application_id'));
      # Log::stack(['single'])->debug("[STRIPE] :" . $application . "-" . $membershipPrice);

      $payment_description = $application->id . '# ' . $application->childfirstname . ' / ' . $application->parentfirstname . ' ' . $application->parentlastname . ' (Price: ' . $membershipPrice->mount . ' GBP - Rallye: ' . $application->rallye->title . ')';
      Log::stack(['single'])->debug("[STRIPE] Payment Description:" . $payment_description);


      Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
      $intent = Stripe\PaymentIntent::create([
        'amount' => $membershipPrice->mount * 100,
        'currency' => config('constants.paymentDetails.currency'),
        'automatic_payment_methods' => ['enabled' => true],
        "description" => $payment_description
      ]);
      ob_start();
      Log::stack(['single'])->debug("[STRIPE] : New Payment Intent:" . $intent->id);
      echo ("New Order: " . $intent->id);
      error_log(ob_get_clean(), 4);
      // return response()->json($intent);

      $data = [
        'application' => $application,
        'membershipPrice' => $membershipPrice,
        'intent' => $intent,
        'description' => $payment_description
      ];
      return view('stripe')->with($data);
    } catch (Exception $e) {
      Log::stack(['single'])->error("[EXCEPTION] - [Stripe] : ça passe  pas !" .  $e->getMessage());
      return Redirect::back()->withError('E229: ' . $e->getMessage());
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
