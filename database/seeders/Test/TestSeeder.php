<?php

use Illuminate\Database\Seeder;

class Database\Seeders\TestSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call([
      Database\Seeders\Test\ApplicationSeeder::class
    ]);
  }
}
