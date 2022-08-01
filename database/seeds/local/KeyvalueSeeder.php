<?php

namespace Seeds\Local;

use Illuminate\Database\Seeder;
use App\Models\KeyValue;

class KeyvalueSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    KeyValue::create([
      'key' => 'PAYMENT_LINK',
      'value' => env('APP_URL') . '/paymentsearch'
    ]);

    KeyValue::create([
      'key' => 'DOMAIN_LINK',
      'value' => env('APP_URL') . '/'
    ]);

    KeyValue::create([
      'key' => 'OFFICIAL_LINK',
      'value' => env('APP_URL') . '/'
    ]);
  }
}
