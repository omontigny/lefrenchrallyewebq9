<?php

namespace App;

use App\Exceptions\StripeException;

class StripeFake
{
  //
  public function charge($token, $amount)
  {
    if ($token === 'tok_visa') {
      return '4242';
    } else {
      throw new StripeException;
    }
  }
}
