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
  public function test_ItWorks()
  {
    $stripe = app(Stripe::class);
    $last4 = $stripe->charge('tok_visa', 10 * 100, "This is a corect charge for testing");
    $this->assertEquals(self::LAST4['tok_visa'], $last4);
  }

  public function test_ItDoesntWorks()
  {

    $stripe = app(Stripe::class);
    try {
      $stripe->charge('token_invalid', 10 * 100, "This is a voluntary charge error for testing");
    } catch (StripeException $e) {
      $this->assertTrue(true);
      return;
    }

    $this->fail("Stripe succeeded"); #le test doit echouer
  }
}
