<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\StripeFake;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StripeFakeTest extends StripeTest
{
  protected function setUp(): void
  {
    parent::setUp();
    app()->instance(Stripe::class, new StripeFake);
  }
}
