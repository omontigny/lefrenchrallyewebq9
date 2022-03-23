<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use \App\Models\School;
use \App\User;
use \App\Models\Coordinator;
use CoordinatorSeeder;
use Faker\Generator as Faker;
use UserSeeder;

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
    factory(User::class)->create([
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
    $this->seed(UserSeeder::class);
    $this->assertCount(3, User::all());
  }
}
