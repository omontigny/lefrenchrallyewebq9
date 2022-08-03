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

    $rallye1 = Rallye::where('title', 'RALLYE NOTTING HILL')->first();
    $rallye2 = Rallye::where('title', 'RALLYE BERKELEY')->first();
    $rallye3 = Rallye::where('title', 'RALLYE WINDSOR')->first();

    $oli    = Coordinator::where('username', 'omontigny')->first();
    $webmaster  = Coordinator::where('username', 'webmaster')->first();
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
    }

    if ($webmaster) {
      Coordinator_Rallye::create([
        'coordinator_id'  => $webmaster->id,
        'rallye_id'       => $rallye1->id,
        'active_rallye'   => '0'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $webmaster->id,
        'rallye_id'       => $rallye2->id,
        'active_rallye'   => '0'
      ]);

      Coordinator_Rallye::create([
        'coordinator_id'  => $webmaster->id,
        'rallye_id'       => $rallye3->id,
        'active_rallye'   => '1'
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
