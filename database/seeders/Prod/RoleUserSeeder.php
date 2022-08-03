<?php

namespace Database\Seeders\Prod;

use Illuminate\Database\Seeder;
use App\Models\Role_User;
use App\Models\Role;
use App\User;

class RoleUserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $role_superadmin = Role::where('rolename', 'SUPERADMIN')->first();
    $role_coordinator = Role::where('rolename', 'COORDINATOR')->first();
    $user1 = User::where('name', 'omontigny')->first();
    $user2 = User::where('email', 'webmaster')->first();
    $user3 = User::where('name', 'tbuisson')->first();
    $user4 = User::where('name', 'elfi')->first();

    if ($user1) {
      Role_User::create([
        'role_id' => $role_superadmin->id,
        'user_id' => $user1->id
      ]);

      Role_User::create([
        'role_id' => $role_coordinator->id,
        'user_id' => $user1->id
      ]);
    }
    if ($user2) {
      Role_User::create([
        'role_id' => $role_superadmin->id,
        'user_id' => $user2->id
      ]);

      Role_User::create([
        'role_id' => $role_coordinator->id,
        'user_id' => $user2->id
      ]);
    }
    if ($user3) {
      Role_User::create([
        'role_id' => $role_superadmin->id,
        'user_id' => $user3->id
      ]);
    }
    if ($user4) {
      Role_User::create([
        'role_id' => $role_coordinator->id,
        'user_id' => $user4->id
      ]);
    }
  }
}
