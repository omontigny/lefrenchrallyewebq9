<?php

namespace Database\Seeders\Local;

use Illuminate\Database\Seeder;
use App\Models\MembershipPrice;
use App\Models\Schoolyear;

class MembershipPriceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    $schoolyear2 = Schoolyear::where('current_level', '2nde - Year 11')->first();
    $schoolyear3 = Schoolyear::where('current_level', '1ere - Year 12')->first();


    if ($schoolyear2) {
      MembershipPrice::create([
        'is_boarder'    => 0,
        'schoolyear_id' => $schoolyear2->id,
        'mount' => 120
      ]);

      MembershipPrice::create([
        'is_boarder'    => 1,
        'schoolyear_id' => $schoolyear2->id,
        'mount' => 120
      ]);
    }

    if ($schoolyear3) {
      MembershipPrice::create([
        'is_boarder'    => 0,
        'schoolyear_id' => $schoolyear3->id,
        'mount' => 120
      ]);

      MembershipPrice::create([
        'is_boarder'    => 1,
        'schoolyear_id' => $schoolyear3->id,
        'mount' => 120
      ]);
    }
  }
}
