<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use \App\Models\School;
use \App\User;
use Faker\Generator as Faker;

class SchoolTest extends TestCase
{

  use RefreshDatabase;
  # use WithoutMiddleware;
  /**
   *
   * @return void
   * @test
   * @group school
   */
  public function test_add_a_school()
  {
    # $this->withoutExceptionHandling();

    $user_admin = User::factory()->create([
      'email' => 'admin@myapp.fr',
      'name' => 'admin',
      'email_verified_at' => now(),
      'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
      'remember_token' => Str::random(10),
      'active_profile' => 'SUPERADMIN',
      'admin' => 2,
      'coordinator' => 1,
      'parent'  => 0,
    ]);

    $this->assertCount(1, User::all());
    # dd($user->name);
    School::factory()->create([
      'name' => 'SCHOOL C',
      'state' => 'SPANISH',
      'added_by' => $user_admin->name,
      'user_id' => $user_admin->id
    ]);

    $this->assertCount(1, School::all());
    $this->assertDatabaseHas('schools', [
      'name' => 'SCHOOL C',
      'added_by' => 'admin',
    ]);
  }

  /**
   *
   * @return void
   * @test
   * @group school
   */
  // public function test_a_school_can_be_added_with_post()
  // {
  //   $this->withoutExceptionHandling();
  //   $this->withoutMiddleware();

  //   $user = User::create([
  //     'id' => 1,
  //     'name' => 'toto',
  //     'email' => 'sally@example.com',
  //     'email_verified_at' => now(),
  //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
  //     'remember_token' => Str::random(10),
  //   ]);

  //   $this->assertCount(1, User::all());

  //   # dd($user->name);
  //   // $response = $this->withHeaders([
  //   //   'X-Header' => 'Value',
  //   // ])->json('POST', '/schoolsStore', [
  //   //   'name' => 'SCHOOL C',
  //   //   'state' => 'SPANISH'
  //   //   // 'added_by' => $user->name,
  //   //   // 'user_id' => $user->id
  //   // ]);



  //   $response = $this->post('schoolsStore', [
  //     'name' => 'SCHOOL C',
  //     'state' => 'SPANISH',

  //   ]);

  //   // $response->dumpHeaders();

  //   // $response->dumpSession();

  //   //$response->dump();
  //   //    dd($response->getContent());

  //   $response->assertOK();
  //   $this->assertCount(1, School::all());
  //   $this->assertDatabaseHas('schools', [
  //     'name' => 'SCHOOL C',
  //     'added_by' => 'toto',
  //     'user_id' => 1,
  //   ]);
  // }
}
