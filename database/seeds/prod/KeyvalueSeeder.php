<?php

namespace Seeds\Prod;

use Illuminate\Database\Seeder;
use App\Models\KeyValue;
use Illuminate\Support\Facades\App;

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


    if (App::environment() === 'prod') {
      $public_url = 'https://www.lefrenchrallye.com';
    } else {
      $public_url = env('APP_URL');
    };
    KeyValue::create([
      'key' => 'OFFICIAL_LINK',
      'value' => $public_url . '/'
    ]);
  }
}
