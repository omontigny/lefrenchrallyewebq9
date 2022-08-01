<?php

namespace Database\Seeders\Test;

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

    $admin = User::where('admin', 2)->first();
    $rallye1 = Rallye::where('title', 'STD 1')->first();
    $rallye2 = Rallye::where('title', 'STD 2')->first();
    $rallye3 = Rallye::where('title', 'SMALL 1')->first();
    $rallye4 = Rallye::where('title', 'SMALL 2')->first();

    if ($admin && $rallye1) {
      Admin_Rallye::create([
        'rallye_id'       => $rallye1->id,
        'user_id'         => $admin->id,
        'active_rallye'   => ''
      ]);
    }

    if ($admin && $rallye2) {
      Admin_Rallye::create([
        'rallye_id'       => $rallye2->id,
        'user_id'         => $admin->id,
        'active_rallye'   => ''
      ]);
    }

    if ($admin && $rallye3) {
      Admin_Rallye::create([
        'rallye_id'      => $rallye3->id,
        'user_id'        => $admin->id,
        'active_rallye'  => '1'
      ]);
    }

    if ($admin && $rallye4) {
      Admin_Rallye::create([
        'rallye_id'       => $rallye4->id,
        'user_id'         => $admin->id,
        'active_rallye'   => ''
      ]);
    }
  }
}
