<?php

namespace Database\Seeders\Local;

use Illuminate\Database\Seeder;
use App\Models\Rallye;
use App\User;

class RallyeSeeder extends Seeder
{
  /* A Modifier en Prod au Reset nouvelle année */
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    $coordinator = User::where('active_profile', 'COORDINATOR')->first();

    if ($coordinator) {

      Rallye::create([
        'title'         => 'STD 1',
        'isPetitRallye' => 0,
        'user_id'       => $coordinator->id,
        'status'        => 0,
        'rallyemail'    => "std1@lefrenchrallye-qual.com"
      ]);

      Rallye::create([
        'title'         => 'STD 2',
        'isPetitRallye' => 0,
        'user_id'       => $coordinator->id,
        'status'        => 0,
        'rallyemail'    => "std2@lefrenchrallye-qual.com"
      ]);

      Rallye::create([
        'title'         => 'SMALL 1',
        'isPetitRallye' => 1,
        'user_id'       => $coordinator->id,
        'status'        => 0,
        'rallyemail'    => "small1@lefrenchrallye-qual.com"
      ]);

      Rallye::create([
        'title'         => 'SMALL 2',
        'isPetitRallye' => 1,
        'user_id'       => $coordinator->id,
        'status'        => 0,
        'rallyemail'    => "small2@lefrenchrallye-qual.com"
      ]);
    }
  }
}
