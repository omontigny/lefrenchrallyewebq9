<?php

namespace Seeds\Prod;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
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

    // Schema::disableForeignKeyConstraints();
    // User::truncate();
    // Schema::enableForeignKeyConstraints();

    //factory(App\User::class, 50)->create();
    factory(User::class)->create([
      'email' => 'olivier@it-r.fr',
      'name' => 'omontigny',
      'active_profile' => 'SUPERADMIN',
      'admin' => 2,
      'coordinator' => 1,
      'parent'  => 0,
    ]);

    factory(User::class)->create([
      'email' => 'webmaster@lefrenchrallye.com',
      'name' => 'cylia',
      'active_profile' => 'COORDINATOR',
      'admin' => 1,
      'coordinator' => 2,
      'parent'  => 0,
    ]);

    factory(User::class)->create([
      'email' => 'thierry@1516.fr',
      'name' => "tbuisson",
      'active_profile' => 'SUPERADMIN',
      'admin' => 2,
      'coordinator' => 0,
      'parent'  => 0,
    ]);

    factory(User::class)->create([
      'email' => 'elfiartero@hotmail.com',
      'name' => 'elfi',
      'active_profile' => 'COORDINATOR',
      'admin' => 1,
      'coordinator' => 2,
      'parent'  => 0,
    ]);
  }
}
