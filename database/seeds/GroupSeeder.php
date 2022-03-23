<?php

use Illuminate\Database\Seeder;
use App\Models\Rallye;
use App\Models\Group;
use App\User;

class GroupSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $admin = User::where('admin', 2)->first();
    $petitrallye1 = Rallye::where('isPetitRallye', 1)->first();
    $stdrallye1 = Rallye::find(1);
    $stdrallye2 = Rallye::find(2);

    if ($admin && $petitrallye1) {
      Group::create([
        'name'        => 'RED',
        'user_id'     => $admin->id,
        'rallye_id'   => $petitrallye1->id,
        'eventDate'   => '2022-05-13',
        'start_year'  => 2021,
        'end_year'    => 2022
      ]);
    }

    if ($admin && $petitrallye1) {
      Group::create([
        'name'        => 'GREEN',
        'user_id'     => $admin->id,
        'rallye_id'   => $petitrallye1->id,
        'eventDate'   => '2022-05-14',
        'start_year'  => 2021,
        'end_year'    => 2022
      ]);
    }
    if ($admin && $stdrallye1) {
      Group::create([
        'name'        => '',
        'user_id'     => $admin->id,
        'rallye_id'   => $stdrallye1->id,
        'eventDate'   => '2022-04-01',
        'start_year'  => 2021,
        'end_year'    => 2022
      ]);
    }
    if ($admin && $stdrallye2) {
      Group::create([
        'name'        => '',
        'user_id'     => $admin->id,
        'rallye_id'   => $stdrallye2->id,
        'eventDate'   => '2022-05-02',
        'start_year'  => 2021,
        'end_year'    => 2022
      ]);
    }
  }
}
