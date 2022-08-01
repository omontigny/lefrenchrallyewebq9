<?php

namespace Seeds\Test;

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
      'email' => 'lucky.luke@myapp.fr',
      'name' => 'lucky',
      'active_profile' => 'COORDINATOR',
      'admin' => 1,
      'coordinator' => 2,
      'parent'  => 0,
    ]);

    factory(User::class)->create([
      'email' => 'ma.dalton@myapp.fr',
      'name' => 'madalton',
      'active_profile' => 'SUPERADMIN',
      'admin' => 2,
      'coordinator' => 1,
      'parent'  => 0,
    ]);

    factory(User::class)->create([
      'email' => 'webmaster@myapp.fr',
      'name' => 'webadmin',
      'active_profile' => 'SUPERADMIN',
      'admin' => 2,
      'coordinator' => 1,
      'parent'  => 0,
    ]);
  }
}
