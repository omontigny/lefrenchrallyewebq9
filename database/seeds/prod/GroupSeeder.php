<?php

namespace Seeds\Prod;

use Illuminate\Database\Seeder;
use App\Models\Rallye;
use App\Models\Group;
use App\User;

class GroupSeeder extends Seeder
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
    $petitrallye1 = Rallye::where('isPetitRallye', 1)->first();
    $stdrallye1   = Rallye::where('title', 'RALLYE BERKELEY 2021 2022')->first();
    $stdrallye2   = Rallye::where('title', 'RALLYE MOUNTBATTEN 2021 2022')->first();

    if ($coordinator && $petitrallye1) {
      Group::create([
        'name'        => 'RED',
        'user_id'     => $coordinator->id,
        'rallye_id'   => $petitrallye1->id,
        'eventDate'   => '2022-05-13',
        'start_year'  => 2021,
        'end_year'    => 2022
      ]);
    }

    if ($coordinator && $petitrallye1) {
      Group::create([
        'name'        => 'GREEN',
        'user_id'     => $coordinator->id,
        'rallye_id'   => $petitrallye1->id,
        'eventDate'   => '2022-05-14',
        'start_year'  => 2021,
        'end_year'    => 2022
      ]);
    }
    if ($coordinator && $stdrallye1) {
      Group::create([
        'name'        => 'Party1',
        'user_id'     => $coordinator->id,
        'rallye_id'   => $stdrallye1->id,
        'eventDate'   => '2021-11-13',
        'start_year'  => 2021,
        'end_year'    => 2022
      ]);
    }
    if ($coordinator && $stdrallye2) {
      Group::create([
        'name'        => 'Party1',
        'user_id'     => $coordinator->id,
        'rallye_id'   => $stdrallye2->id,
        'eventDate'   => '2021-11-13',
        'start_year'  => 2021,
        'end_year'    => 2022
      ]);
    }
  }
}
