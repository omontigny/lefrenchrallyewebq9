<?php

namespace App;

use App\Exceptions\StripeException;
use Stripe\Exception\InvalidRequestException;

class Stripe
{
  //
  public function charge($token, $amount, $description)
  {
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
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
