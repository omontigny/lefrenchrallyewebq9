<?php

namespace Seeds\Prod;

use Illuminate\Database\Seeder;
use App\Models\Rallye;
use App\User;

class RallyeSeeder extends Seeder
{
  /* TODO: Modifier au Reset nouvelle année */
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
        'title'         => 'RALLYE NOTTING HILL 2021-2022',
        'isPetitRallye' => 1,
        'user_id'       => $coordinator->id,
        'status'        => 0,
        'rallyemail'    => "nottinghill@lefrenchrallye.com"
      ]);

      Rallye::create([
        'title'         => 'RALLYE BERKELEY 2021 2022',
        'isPetitRallye' => 0,
        'user_id'       => $coordinator->id,
        'status'        => 0,
        'rallyemail'    => "berkeley@lefrenchrallye.com"
      ]);

      Rallye::create([
        'title'         => 'RALLYE MOUNTBATTEN 2021 2022',
        'isPetitRallye' => 0,
        'user_id'       => $coordinator->id,
        'status'        => 0,
        'rallyemail'    => "mountbatten@lefrenchrallye.com"
      ]);
    }
  }
}
