<?php

namespace Database\Seeders\Local;

use Illuminate\Database\Seeder;
use App\Models\Coordinator_Rallye;
use App\Models\Rallye;
use App\Models\Coordinator;

class CoordinatorRallyeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    $rallye1 = Rallye::where('title', 'STD 1')->first();
    $rallye2 = Rallye::where('title', 'STD 2')->first();
    $rallye3 = Rallye::where('title', 'SMALL 1')->first();
    $rallye4 = Rallye::where('title', 'SMALL 2')->first();

    $oli    = Coordinator::where('username', 'omontigny')->first();
    $cylia  = Coordinator::where('username', 'cylia')->first();
    $elfi   = Coordinator::where('username', 'elfi')->first();


    if ($oli) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $oli->id,
        'rallye_id'       => $rallye1->id,
        'active_rallye'   => '0'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $oli->id,
        'rallye_id'       => $rallye2->id,
        'active_rallye'   => '0'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $oli->id,
        'rallye_id'       => $rallye3->id,
        'active_rallye'   => '1'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $oli->id,
        'rallye_id'       => $rallye4->id,
        'active_rallye'   => '0'
      ]);
    }

    if ($cylia) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $cylia->id,
        'rallye_id'       => $rallye1->id,
        'active_rallye'   => '0'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $cylia->id,
        'rallye_id'       => $rallye2->id,
        'active_rallye'   => '0'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $cylia->id,
        'rallye_id'       => $rallye3->id,
        'active_rallye'   => '1'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $cylia->id,
        'rallye_id'       => $rallye4->id,
        'active_rallye'   => '0'
      ]);
    }

    if ($elfi) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $elfi->id,
        'rallye_id'       => $rallye3->id,
        'active_rallye'   => '1'
      ]);
    }
  }
}
