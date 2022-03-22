<?php

namespace App;

use App\Exceptions\StripeException;
use Stripe\Exception\InvalidRequestException;

class Stripe
{
  //
  public function charge($token, $amount)
  {
    \Stripe\Stripe::setApiKey('sk_test_51Jf7KeDn4MIo6ZX2mNl6ppKCzIpwDEKLGVU7plvB61IwADeAFKllM5BsuvZ4Kd75VCOjLNhcxHEfiuce9PARF8VI00IcnAEjHS');
    try {

      $charge = \Stripe\Charge::create([
        "amount" => $amount,
        "currency" => "eur",
        "source" => $token,
      ]);
      return $charge->source->last4;
    } catch (InvalidRequestException $e) {
      throw new StripeException;
    }
  }
}
