<?php

use Illuminate\Database\Seeder;
use App\Models\Coordinator;
use \App\User;

class CoordinatorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $elfi = User::where('name', 'elfi')->first();
    $oli = User::where('name', 'omontigny')->first();

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
