<?php

namespace Seeds\Prod;

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
    $rallye1 = Rallye::all()[0];
    $rallye2 = Rallye::all()[1];
    $rallye3 = Rallye::all()[2];

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
  }
}
