<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;


class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $environment = App::environment();

    // Load production seeder
    if ($environment === 'prod' || $environment === 'preprod') {
      $this->call([
        Prod\UserSeeder::class,
        Prod\CoordinatorSeeder::class,
        Prod\SchoolSeeder::class,
        Prod\SchoolyearSeeder::class,
        Prod\RoleSeeder::class,
        Prod\RoleUserSeeder::class,
        Prod\RallyeSeeder::class,
        Prod\AdminRallyeSeeder::class,
        Prod\GroupSeeder::class,
        Prod\CoordinatorRallyeSeeder::class,
        Prod\MembershipPriceSeeder::class,
        Prod\KeyvalueSeeder::class
      ]);
    }

    // Load local seeder
    if ($environment  === 'local') {

      $this->call([
        Local\UserSeeder::class,
        Local\CoordinatorSeeder::class,
        Local\SchoolSeeder::class,
        Local\SchoolyearSeeder::class,
        Local\RoleSeeder::class,
        Local\RoleUserSeeder::class,
        Local\RallyeSeeder::class,
        Local\AdminRallyeSeeder::class,
        Local\GroupSeeder::class,
        Local\CoordinatorRallyeSeeder::class,
        Local\MembershipPriceSeeder::class,
        Local\KeyvalueSeeder::class
      ]);
    }

    // Load local seeder
    if ($environment  === 'testing') {

      $this->call([
        Test\UserSeeder::class,
        Test\CoordinatorSeeder::class,
        Test\SchoolSeeder::class,
        Test\SchoolyearSeeder::class,
        Test\RoleSeeder::class,
        Test\RoleUserSeeder::class,
        Test\RallyeSeeder::class,
        Test\AdminRallyeSeeder::class,
        Test\GroupSeeder::class,
        Test\CoordinatorRallyeSeeder::class,
        Test\MembershipPriceSeeder::class,
        Test\KeyvalueSeeder::class,
        Test\ApplicationSeeder::class
      ]);
    }
  }
}
