<?php

use Illuminate\Database\Seeder;
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
    $admin = User::where('admin', 2)->first();

    if ($admin) {
      School::create([
        'name'      => 'SCHOOL A',
        'state'     => 'ENGLISH',
        'added_by'  => $admin->name,
        'user_id'   => $admin->id,
        'approved'  => 0
      ]);

      School::create([
        'name'      => 'SCHOOL B',
        'state'     => 'FRENCH',
        'added_by'  => $admin->name,
        'user_id'   => $admin->id,
        'approved'  => 0
      ]);
    }
  }
}
