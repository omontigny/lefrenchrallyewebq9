<?php

namespace Database\Seeders\Local;

use Illuminate\Database\Seeder;
use App\Models\Rallye;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Application;
use App\Models\Group;
use App\User;

class ApplicationSmallSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */

  public function run()
  {
    $smallrallye1   = Rallye::where('title', 'SMALL 1')->first();

    $school       = School::all()->first();
    $schoolyear2  = Schoolyear::where('current_level', '3eme - Year 10')->first();
    $lastname     =  "LASTNAME" . rand(2, 100);
    $imagePath = public_path('/assets/images/avatar1.jpg');
    $image_base64 = base64_encode(file_get_contents($imagePath, true));
    $childphotopath = 'data:image/jpg;base64,' . $image_base64;


    Application::create(
      [
        'rallye_id'       =>  $smallrallye1->id,
        'childfirstname'  =>  'Enfant' . rand(2, 1000),
        'childlastname'   =>   $lastname,
        'childbirthdate'  =>  rand(2010, 2015) . '-' . rand(3, 12) . '-' . rand(1, 30),
        'childgender'     =>  'MALE',
        'childemail'      =>  '',
        'childphotopath' =>  $childphotopath,
        'simblingList' =>  '',
        'hasinsurancecover' =>  1,
        'school_id' => $school->id,
        'schoolyear_id' => $schoolyear2->id,
        'schoolstate' => $school->state,
        'parentfirstname' => 'Parent',
        'parentlastname' => $lastname,
        'parentaddress' => 'MON ADRESS, 75000 PARIS',
        'parenthomephone' => '+33201010101',
        'parentmobile' => '+33601010101',
        'parentemail' => 'parentsmall' . rand(2, 1000) . '@' . env('APP_DOMAIN'),
        'signingcodeconduct' => 'I accept',
        'dpp1' => 1,
        'dpp2' => 1,
        'otc1' => 1,
        'otc2' => 1,
        'status' => 0,
        'is_boarder' => 0,
        'submitted' => 0,
        'previous_status' => 0,
        'grouped' => 0,
        'previous_group_status' => 0,
        'deleted' => 0,
        'evented' => 0,
        'extension' => 'jpeg',
        'mailto' => 0,
      ]
    );

    $smallrallye2   = Rallye::where('title', 'SMALL 2')->first();
    $school       = School::all()->last();
    $schoolyear2  = Schoolyear::where('current_level', '3eme - Year 10')->first();
    $lastname     =  "LASTNAME" . rand(2, 100);
    $imagePath = public_path('/assets/images/avatar2.jpg');
    $image_base64 = base64_encode(file_get_contents($imagePath, true));
    $childphotopath = 'data:image/jpg;base64,' . $image_base64;

    Application::create(
      [
        'rallye_id'       =>  $smallrallye2->id,
        'childfirstname'  =>  'Enfant' . rand(2, 1000),
        'childlastname'   =>   $lastname,
        'childbirthdate'  =>  rand(2010, 2015) . '-' . rand(3, 12) . '-' . rand(1, 30),
        'childgender'     =>  'MALE',
        'childemail'      =>  '',
        'childphotopath' =>  $childphotopath,
        'simblingList' =>  '',
        'hasinsurancecover' =>  1,
        'school_id' => $school->id,
        'schoolyear_id' => $schoolyear2->id,
        'schoolstate' => $school->state,
        'parentfirstname' => 'Parent',
        'parentlastname' => $lastname,
        'parentaddress' => 'MON ADRESS, 75000 PARIS',
        'parenthomephone' => '+33201010101',
        'parentmobile' => '+33601010101',
        'parentemail' => 'parentsmall' . rand(2, 1000) . '@' . env('APP_DOMAIN'),
        'signingcodeconduct' => 'I accept',
        'dpp1' => 1,
        'dpp2' => 1,
        'otc1' => 1,
        'otc2' => 1,
        'status' => 0,
        'is_boarder' => 0,
        'submitted' => 0,
        'previous_status' => 0,
        'grouped' => 0,
        'previous_group_status' => 0,
        'deleted' => 0,
        'evented' => 0,
        'extension' => 'jpeg',
        'mailto' => 0,
      ]
    );
  }
}
