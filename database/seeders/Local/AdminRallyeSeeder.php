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
    $rallye1 = Rallye::where('title', 'STD 1')->first();
    $rallye2 = Rallye::where('title', 'STD 2')->first();
    $rallye3 = Rallye::where('title', 'SMALL 1')->first();
    $rallye4 = Rallye::where('title', 'SMALL 2')->first();

    if ($coordinator && $rallye1) {
      Admin_Rallye::create([
        'rallye_id'       => $rallye1->id,
        'user_id'         => $coordinator->id,
        'active_rallye'   => ''
      ]);
    }

    if ($coordinator && $rallye2) {
      Admin_Rallye::create([
        'rallye_id'       => $rallye2->id,
        'user_id'         => $coordinator->id,
        'active_rallye'   => ''
      ]);
    }

    if ($coordinator && $rallye3) {
      Admin_Rallye::create([
        'rallye_id'      => $rallye3->id,
        'user_id'        => $coordinator->id,
        'active_rallye'  => '1'
      ]);
    }

    if ($coordinator && $rallye4) {
      Admin_Rallye::create([
        'rallye_id'       => $rallye4->id,
        'user_id'         => $coordinator->id,
        'active_rallye'   => ''
      ]);
    }
  }
}
