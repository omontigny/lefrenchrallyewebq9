<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
  /**
   * A basic test example.
   *
   * @return void
   * @test
   * @group basic
   */
  public function test_BasicTest()
  {
    $response = $this->get('/welcome');

    $response->assertStatus(200);
  }
}
