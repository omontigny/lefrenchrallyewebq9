<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedTest extends TestCase
{
  use RefreshDatabase;
  /**
   * A basic feature test example.
   *
   * @return void
   * @test
   * @group seed
   */

  public function test_seed_all_database()
  {
    // Run the DatabaseSeeder...
    $this->seed();

    $this->assertCount(3, \App\User::all());
    $this->assertCount(2, \App\Models\Coordinator::all());
    $this->assertEquals('omontigny', \App\Models\Coordinator::find(1)->username);
    $this->assertEquals('elfi', \App\Models\Coordinator::find(2)->username);
    $this->assertCount(2, \App\Models\School::all());
    $this->assertCount(3, \App\Models\Schoolyear::all());
    $this->assertCount(3, \App\Models\Role::all());
    $this->assertCount(4, \App\Models\Role_User::all());
    $this->assertCount(4, \App\Models\Rallye::all());
    $this->assertCount(4, \App\Models\Admin_Rallye::all());
    $this->assertCount(4, \App\Models\Group::all());
    $this->assertCount(4, \App\Models\Coordinator_Rallye::all());
    $this->assertCount(6, \App\Models\MembershipPrice::all());
    $this->assertCount(3, \App\Models\KeyValue::all());
  }
}
