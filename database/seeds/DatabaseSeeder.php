<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call(UserSeeder::class);
    $this->call(CoordinatorSeeder::class);
    $this->call(SchoolSeeder::class);
    $this->call(SchoolyearSeeder::class);
    $this->call(RoleSeeder::class);
    $this->call(RoleUserSeeder::class);
    $this->call(RallyeSeeder::class);
    $this->call(AdminRallyeSeeder::class);
    $this->call(GroupSeeder::class);
    $this->call(CoordinatorRallyeSeeder::class);
    $this->call(MembershipPriceSeeder::class);
    $this->call(KeyvalueSeeder::class);
  }
}
