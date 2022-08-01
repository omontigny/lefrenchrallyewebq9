<?php

namespace Database\Seeders\Prod;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Role::create([
      'rolename'      => 'SUPERADMIN'
    ]);
    Role::create([
      'rolename'      => 'COORDINATOR'
    ]);
    Role::create([
      'rolename'      => 'PARENT'
    ]);
  }
}
