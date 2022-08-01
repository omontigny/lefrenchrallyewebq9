<?php

namespace Seeds\Local;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

use App\Models\School;
use App\User;

class SchoolSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Schema::disableForeignKeyConstraints();
    // School::truncate();
    // Schema::enableForeignKeyConstraints();
    $test = 0;
    $coordinator = User::where('active_profile', 'COORDINATOR')->first();

    if ($coordinator) {
      $json = File::get("database/data/schools.json");
      $schools = json_decode($json);

      foreach ($schools as $key => $value) {
        School::create([
          "name" => $value->name,
          "state" => $value->state,
          'added_by'  => $coordinator->name,
          'user_id'   => $coordinator->id,
          'approved'  => 0
        ]);
      }

      if ($test == 1)
        School::create([
          'name'      => 'SCHOOL A',
          'state'     => 'ENGLISH',
          'added_by'  => $coordinator->name,
          'user_id'   => $coordinator->id,
          'approved'  => 0
        ]);

        School::create([
          'name'      => 'SCHOOL B',
          'state'     => 'FRENCH',
          'added_by'  => $coordinator->name,
          'user_id'   => $coordinator->id,
          'approved'  => 0
        ]);
      }
    }
  }
}
