<?php

namespace App;

use App\Exceptions\StripeException;
use Stripe\Exception\InvalidRequestException;

class Stripe
{
  //
  public function charge($token, $amount, $description)
  {
    // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    \Stripe\Stripe::setApiKey('rk_test_51Jf7KeDn4MIo6ZX2VHZ0I5pB3U38BVunNbbdqG6fJId7xyPe7gaMbnsrJ58pBOEl56O0WKyqbt8e45moRNTCdLhr00kLI5KFTL');

    try {

      $charge = \Stripe\Charge::create([
        "amount" => $amount,
        "currency" => "eur",
        "source" => $token,
        "description" => $description
      ]);
      return $charge->source->last4;
    } catch (InvalidRequestException $e) {
      throw new StripeException;
    }
  }
}
