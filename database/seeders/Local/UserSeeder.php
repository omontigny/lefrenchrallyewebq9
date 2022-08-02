<?php

namespace Database\Seeders\Local;

use App\USer;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // User::factory()->times(30)->create();
    //factory(App\User::class, 50)->create();
    User::factory()->create([
      'email' => 'olivier@lefrenchrallye.local',
      'name' => 'omontigny',
      'active_profile' => 'SUPERADMIN',
      'admin' => 2,
      'coordinator' => 1,
      'parent'  => 0,
    ]);

    User::factory()->create([
      'email' => 'webmaster@lefrenchrallye.local',
      'name' => 'cylia',
      'active_profile' => 'COORDINATOR',
      'admin' => 1,
      'coordinator' => 2,
      'parent'  => 0,
    ]);

    User::factory()->create([
      'email' => 'elfi@lefrenchrallye.local',
      'name' => 'elfi',
      'active_profile' => 'COORDINATOR',
      'admin' => 1,
      'coordinator' => 2,
      'parent'  => 0,
    ]);
  }
}
