<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Stripe;
use App\Exceptions\StripeException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StripeTest extends TestCase
{

  const LAST4 = [
    'tok_visa' => '4242',
  ];
  /**
   * A basic unit test example.
   *
   * @return void
   */
  public function testItWorks()
  {
    $stripe = app(Stripe::class);
    $last4 = $stripe->charge('tok_visa', 10 * 100);
    $this->assertEquals(self::LAST4['tok_visa'], $last4);
  }

  public function testItDoesntWorks()
  {

    $stripe = app(Stripe::class);
    try {
      $stripe->charge('token_invalid', 10 * 100);
    } catch (StripeException $e) {
      $this->assertTrue(true);
      return;
    }

    $this->fail("Stripe succeeded"); #le test doit echouer
  }
}
