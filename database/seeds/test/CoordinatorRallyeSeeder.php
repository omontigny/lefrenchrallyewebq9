<?php

namespace Seeds\Test;

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

    $coordinator = Coordinator::all()->first();

    if ($coordinator && $rallye3) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $coordinator->id,
        'rallye_id'       => $rallye3->id,
        'active_rallye'   => '1'
      ]);
    }

    if ($coordinator && $rallye4) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $coordinator->id,
        'rallye_id'       => $rallye4->id,
        'active_rallye'   => ''
      ]);
    }

    if ($coordinator && $rallye1) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $coordinator->id,
        'rallye_id'       => $rallye1->id,
        'active_rallye'   => ''
      ]);
    }

    if ($coordinator && $rallye2) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $coordinator->id,
        'rallye_id'       => $rallye2->id,
        'active_rallye'   => ''
      ]);
    }
  }
}
