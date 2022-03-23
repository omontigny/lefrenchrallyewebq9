<?php

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
    $rallye1 = Rallye::find(1);
    $rallye2 = Rallye::find(2);
    $rallye3 = Rallye::find(3);
    $rallye4 = Rallye::find(4);

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
