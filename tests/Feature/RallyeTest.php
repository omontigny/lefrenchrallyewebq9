<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \App\Models\Rallye;
use \App\User;
use Faker\Generator as Faker;

class RallyeTest extends TestCase
{
  use RefreshDatabase;
  /**
   * A basic feature test example.
   *
   * @return void
   * @test
   * @group rallye
   */
  public function test_as_one_rallye()
  {
    $user = factory(User::class)->create();


    Rallye::create([
      'title'         => 'STD 1',
      'isPetitRallye' => 0,
      'user_id'       => $user->id,
      'status'        => 1,
      'rallyemail'    => "std1@lefrenchrallye-qual.com"
    ]);

    $this->assertCount(1, Rallye::all());
  }
}
