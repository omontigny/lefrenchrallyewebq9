<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\User;


class UserTest extends TestCase
{

  use RefreshDatabase;
  /**
   *
   * @return void
   * @test
   * @group user
   */

  public function test_as_one_user()
  {
    User::factory()->create([
      'email' => 'sally@example.com',
    ]);

    $this->assertCount(1, User::all());

    $this->assertDatabaseHas('users', [
      'email' => 'sally@example.com',
    ]);
  }

  /**
   *
   * @return void
   * @test
   * @group user
   */
  public function test_creating_a_new_user()
  {
    User::factory()->create([
      'email' => 'lucky.luke@myapp.fr',
      'name' => 'lucky',
      'active_profile' => 'COORDINATOR',
      'admin' => 1,
      'coordinator' => 2,
      'parent'  => 0,
    ]);

    User::factory()->create([
      'email' => 'ma.dalton@myapp.fr',
      'name' => 'madalton',
      'active_profile' => 'SUPERADMIN',
      'admin' => 2,
      'coordinator' => 1,
      'parent'  => 0,
    ]);

    User::factory()->create([
      'email' => 'webmaster@myapp.fr',
      'name' => 'webadmin',
      'active_profile' => 'SUPERADMIN',
      'admin' => 2,
      'coordinator' => 1,
      'parent'  => 0,
    ]);

    $this->assertCount(3, User::all());
    $this->assertDatabaseHas('users', [
      'email' => 'lucky.luke@myapp.fr',
    ]);
  }
}
