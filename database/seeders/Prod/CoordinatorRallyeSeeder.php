<?php

namespace Database\Seeders\Prod;

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

    $petitrallye = Rallye::where('isPetitRallye', 1)->first();
    $stdrallye1   = Rallye::where('title', 'RALLYE BERKELEY')->first();
    $stdrallye2   = Rallye::where('title', 'RALLYE NOTTING HILL')->first();

    $oli    = Coordinator::where('username', 'omontigny')->first();
    $webmaster  = Coordinator::where('username', 'webmaster')->first();
    $elfi   = Coordinator::where('username', 'elfi')->first();

    if ($oli) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $oli->id,
        'rallye_id'       => $petitrallye->id,
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

    if ($webmaster) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $webmaster->id,
        'rallye_id'       => $petitrallye->id,
        'active_rallye'   => '1'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $webmaster->id,
        'rallye_id'       => $stdrallye1->id,
        'active_rallye'   => '0'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $webmaster->id,
        'rallye_id'       => $stdrallye2->id,
        'active_rallye'   => '0'
      ]);
    }

    if ($elfi) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $elfi->id,
        'rallye_id'       => $petitrallye->id,
        'active_rallye'   => '1'
      ]);
    }
  }
}
