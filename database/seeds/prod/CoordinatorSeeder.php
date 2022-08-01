<?php

namespace Seeds\Prod;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Coordinator;
use App\User;

class CoordinatorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Schema::disableForeignKeyConstraints();
    // Coordinator::truncate();
    // Schema::enableForeignKeyConstraints();

    $oli    = User::where('name', 'omontigny')->first();
    $cylia  = User::where('name', 'cylia')->first();
    $elfi   = User::where('name', 'elfi')->first();

    if ($oli) {
      Coordinator::create([
        'firstname' => 'Olivier',
        'lastname' => 'MONTIGNY',
        'username' => $oli->name,
        'mail' => $oli->email,
        'status' => 0,
        'user_id'  => $oli->id
      ]);
    }
    if ($cylia) {
      Coordinator::create([
        'firstname' => 'ADMIN',
        'lastname' => 'SUPER',
        'username' => $cylia->name,
        'mail' => $cylia->email,
        'status' => 0,
        'user_id'  => $cylia->id
      ]);
    }
    if ($elfi) {
      Coordinator::create([
        'firstname' => 'Elfi',
        'lastname' => 'ATTON-BROWN',
        'username' => $elfi->name,
        'mail' => $elfi->email,
        'status' => 0,
        'user_id'  => $elfi->id
      ]);
    }
  }
}
