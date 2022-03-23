<?php

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
    $elfi = User::where('name', 'elfi')->first();
    if ($elfi) {
      Schoolyear::create([
        'current_level'  => '3eme - Year 10',
        'next_level' => '',
        'user_id' => $elfi->id
      ]);
      Schoolyear::create([
        'current_level'  => '2nde - Year 11',
        'next_level' => '',
        'user_id' => $elfi->id
      ]);
      Schoolyear::create([
        'current_level'  => '1ere - Year 12',
        'next_level' => '',
        'user_id' => $elfi->id
      ]);
    }
  }
}
