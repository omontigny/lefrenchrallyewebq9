<?php

namespace Seeds\Test;

use Illuminate\Database\Seeder;
use App\Models\Schoolyear;
use App\User;

class SchoolyearSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $lucky = User::where('name', 'lucky')->first();
    if ($lucky) {
      Schoolyear::create([
        'current_level'  => '3eme - Year 10',
        'next_level' => '',
        'user_id' => $lucky->id
      ]);
      Schoolyear::create([
        'current_level'  => '2nde - Year 11',
        'next_level' => '',
        'user_id' => $lucky->id
      ]);
      Schoolyear::create([
        'current_level'  => '1ere - Year 12',
        'next_level' => '',
        'user_id' => $lucky->id
      ]);
    }
  }
}
