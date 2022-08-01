<?php

namespace Seeds\Prod;

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

    $petitrallye1 = Rallye::where('isPetitRallye', 1)->first();
    $stdrallye1   = Rallye::where('title', 'RALLYE BERKELEY')->first();
    $stdrallye2   = Rallye::where('title', 'RALLYE MOUNTBATTEN')->first();

    $oli    = Coordinator::where('username', 'omontigny')->first();
    $cylia  = Coordinator::where('username', 'cylia')->first();
    $elfi   = Coordinator::where('username', 'elfi')->first();

    if ($oli) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $oli->id,
        'rallye_id'       => $petitrallye1->id,
        'active_rallye'   => '1'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $oli->id,
        'rallye_id'       => $stdrallye1->id,
        'active_rallye'   => '0'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $oli->id,
        'rallye_id'       => $stdrallye2->id,
        'active_rallye'   => '0'
      ]);
    }

    if ($cylia) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $cylia->id,
        'rallye_id'       => $petitrallye1->id,
        'active_rallye'   => '1'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $cylia->id,
        'rallye_id'       => $stdrallye1->id,
        'active_rallye'   => '0'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $cylia->id,
        'rallye_id'       => $stdrallye2->id,
        'active_rallye'   => '0'
      ]);
    }

    if ($elfi) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $elfi->id,
        'rallye_id'       => $petitrallye1->id,
        'active_rallye'   => '1'
      ]);
    }
  }
}
