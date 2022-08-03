<?php

namespace Database\Seeders\Local;

use Illuminate\Database\Seeder;
use App\Models\Admin_Rallye;
use App\Models\Rallye;
use App\User;

class AdminRallyeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    $coordinator = User::where('active_profile', 'COORDINATOR')->first();
    $petitrallye = Rallye::where('isPetitRallye', 1)->first();
    $rallyestd1 = Rallye::where('title', 'RALLYE NOTTING HILL')->first();
    $rallyestd2 = Rallye::where('title', 'RALLYE BERKELEY')->first();

    if ($coordinator && $rallyestd1) {
      Admin_Rallye::create([
        'rallye_id'       => $rallyestd1->id,
        'user_id'         => $coordinator->id,
        'active_rallye'   => ''
      ]);
    }

    if ($coordinator && $rallyestd2) {
      Admin_Rallye::create([
        'rallye_id'       => $rallyestd2->id,
        'user_id'         => $coordinator->id,
        'active_rallye'   => ''
      ]);
    }

    if ($coordinator && $petitrallye) {
      Admin_Rallye::create([
        'rallye_id'      => $petitrallye->id,
        'user_id'        => $coordinator->id,
        'active_rallye'  => '1'
      ]);
    }
  }
}
