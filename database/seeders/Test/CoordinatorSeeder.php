<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;
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
    $lucky = User::where('name', 'lucky')->first();
    $madalton = User::where('name', 'madalton')->first();

    if ($madalton) {
      Coordinator::create([
        'firstname' => 'Ma',
        'lastname' => 'DALTON',
        'username' => $madalton->name,
        'mail' => $madalton->email,
        'status' => 0,
        'user_id'  => $madalton->id
      ]);
    }
    if ($lucky) {
      Coordinator::create([
        'firstname' => 'lucky',
        'lastname' => 'ATTON-BROWN',
        'username' => $lucky->name,
        'mail' => $lucky->email,
        'status' => 0,
        'user_id'  => $lucky->id
      ]);
    }
  }
}
