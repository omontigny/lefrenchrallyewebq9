<?php

namespace Database\Seeders\Prod;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
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
  public function run()
  {
    // Schema::disableForeignKeyConstraints();
    // School::truncate();
    // Schema::enableForeignKeyConstraints();

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
    }
  }
}
