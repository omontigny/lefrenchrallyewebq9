<?php

namespace Database\Seeders\Test;

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
    $stdrallye1 = Rallye::where('title', 'STD 1')->first();
    $stdrallye2 = Rallye::where('title', 'STD 2')->first();

    if ($admin && $petitrallye1) {
      Group::create([
        'name'        => 'RED',
        'user_id'     => $admin->id,
        'rallye_id'   => $petitrallye1->id,
        'eventDate'   => '2022-09-13',
        'start_year'  => 2022,
        'end_year'    => 2023
      ]);
    }

    if ($admin && $petitrallye1) {
      Group::create([
        'name'        => 'GREEN',
        'user_id'     => $admin->id,
        'rallye_id'   => $petitrallye1->id,
        'eventDate'   => '2022-09-14',
        'start_year'  => 2022,
        'end_year'    => 2023
      ]);
    }
    if ($admin && $stdrallye1) {
      Group::create([
        'name'        => 'Group1',
        'user_id'     => $admin->id,
        'rallye_id'   => $stdrallye1->id,
        'eventDate'   => '2022-10-13',
        'start_year'  => 2022,
        'end_year'    => 2023
      ]);
    }
    if ($admin && $stdrallye2) {
      Group::create([
        'name'        => 'Group2',
        'user_id'     => $admin->id,
        'rallye_id'   => $stdrallye2->id,
        'eventDate'   => '2022-10-13',
        'start_year'  => 2022,
        'end_year'    => 2023
      ]);
    }
  }
}
