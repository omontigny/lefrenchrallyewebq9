<?php

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
        Seeds\Prod\UserSeeder::class,
        Seeds\Prod\CoordinatorSeeder::class,
        Seeds\Prod\SchoolSeeder::class,
        Seeds\Prod\SchoolyearSeeder::class,
        Seeds\Prod\RoleSeeder::class,
        Seeds\Prod\RoleUserSeeder::class,
        Seeds\Prod\RallyeSeeder::class,
        Seeds\Prod\AdminRallyeSeeder::class,
        Seeds\Prod\GroupSeeder::class,
        Seeds\Prod\CoordinatorRallyeSeeder::class,
        Seeds\Prod\MembershipPriceSeeder::class,
        Seeds\Prod\KeyvalueSeeder::class
      ]);
    }

    // Load local seeder
    if ($environment  === 'local') {

      $this->call([
        Seeds\Local\UserSeeder::class,
        Seeds\Local\CoordinatorSeeder::class,
        Seeds\Local\SchoolSeeder::class,
        Seeds\Local\SchoolyearSeeder::class,
        Seeds\Local\RoleSeeder::class,
        Seeds\Local\RoleUserSeeder::class,
        Seeds\Local\RallyeSeeder::class,
        Seeds\Local\AdminRallyeSeeder::class,
        Seeds\Local\GroupSeeder::class,
        Seeds\Local\CoordinatorRallyeSeeder::class,
        Seeds\Local\MembershipPriceSeeder::class,
        Seeds\Local\KeyvalueSeeder::class
      ]);
    }

    // Load local seeder
    if ($environment  === 'testing') {

      $this->call([
        Seeds\Test\UserSeeder::class,
        Seeds\Test\CoordinatorSeeder::class,
        Seeds\Test\SchoolSeeder::class,
        Seeds\Test\SchoolyearSeeder::class,
        Seeds\Test\RoleSeeder::class,
        Seeds\Test\RoleUserSeeder::class,
        Seeds\Test\RallyeSeeder::class,
        Seeds\Test\AdminRallyeSeeder::class,
        Seeds\Test\GroupSeeder::class,
        Seeds\Test\CoordinatorRallyeSeeder::class,
        Seeds\Test\MembershipPriceSeeder::class,
        Seeds\Test\KeyvalueSeeder::class,
        Seeds\Test\ApplicationSeeder::class
      ]);
    }
  }
}
