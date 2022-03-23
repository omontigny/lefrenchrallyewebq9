<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    //factory(App\User::class, 50)->create();
    factory(User::class)->create([
      'email' => 'olivier.wagon498@free.fr',
      'name' => 'omontigny',
      'active_profile' => 'COORDINATOR',
      'admin' => 1,
      'coordinator' => 2,
      'parent'  => 0,
    ]);

    factory(User::class)->create([
      'email' => 'montigno.ecommerce@free.fr',
      'name' => 'elfi',
      'active_profile' => 'SUPERADMIN',
      'admin' => 2,
      'coordinator' => 1,
      'parent'  => 0,
    ]);

    factory(User::class)->create([
      'email' => 'webmaster@lefrenchrallye.com',
      'name' => 'cylia',
      'active_profile' => 'SUPERADMIN',
      'admin' => 2,
      'coordinator' => 1,
      'parent'  => 0,
    ]);
  }
}
