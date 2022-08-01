<?php

namespace Seeds\Test;

use Illuminate\Database\Seeder;
use App\Models\Rallye;
use App\User;

class RallyeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    $user1 = User::where('coordinator', 2)->first();

    if ($user1) {
      Rallye::create([
        'title'         => 'STD 1',
        'isPetitRallye' => 0,
        'user_id'       => $user1->id,
        'status'        => 1,
        'rallyemail'    => "std1@lefrenchrallye-qual.com"
      ]);

      Rallye::create([
        'title'         => 'STD 2',
        'isPetitRallye' => 0,
        'user_id'       => $user1->id,
        'status'        => 1,
        'rallyemail'    => "std2@lefrenchrallye-qual.com"
      ]);

      Rallye::create([
        'title'         => 'SMALL 1',
        'isPetitRallye' => 1,
        'user_id'       => $user1->id,
        'status'        => 1,
        'rallyemail'    => "small1@lefrenchrallye-qual.com"
      ]);

      Rallye::create([
        'title'         => 'SMALL 2',
        'isPetitRallye' => 1,
        'user_id'       => $user1->id,
        'status'        => 1,
        'rallyemail'    => "small2@lefrenchrallye-qual.com"
      ]);
    }
  }
}
