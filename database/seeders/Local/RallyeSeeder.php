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
        'title'         => 'RALLYE WINDSOR', # 3eme - Year 10
        'isPetitRallye' => 1,
        'user_id'       => $coordinator->id,
        'status'        => 0,
        'rallyemail'    => "windsor@lefrenchrallye.com"
      ]);

      Rallye::create([
        'title'         => 'RALLYE NOTTING HILL', #2nde - Year 11
        'isPetitRallye' => 0,
        'user_id'       => $coordinator->id,
        'status'        => 0,
        'rallyemail'    => "nottinghill@lefrenchrallye.com"
      ]);

      Rallye::create([
        'title'         => 'RALLYE BERKELEY', # 1ere - Year 12
        'isPetitRallye' => 0,
        'user_id'       => $coordinator->id,
        'status'        => 0,
        'rallyemail'    => "berkeley@lefrenchrallye.com"
      ]);
    }
  }
}
