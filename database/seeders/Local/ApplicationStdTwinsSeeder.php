<?php

namespace Database\Seeders\Local;

use Illuminate\Database\Seeder;
use App\Models\Rallye;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Application;
use App\Models\Group;
use App\User;

class ApplicationStdTwinsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //
    $stdrallye1   = Rallye::where('title', 'STD 1')->first();
    $school       = School::all()->first();
    $schoolyear1  = Schoolyear::where('current_level', '2nde - Year 11')->first();
    $lastname     =  "LASTNAME-TWINS";
    $imagePath = public_path('/assets/images/avatar3.jpg');
    $image_base64 = base64_encode(file_get_contents($imagePath, true));
    $childphotopath = 'data:image/jpg;base64,' . $image_base64;

    Application::create(
      [
        'rallye_id'       =>  $stdrallye1->id,
        'childfirstname'  =>  'Enfant1',
        'childlastname'   =>   $lastname,
        'childbirthdate'  =>  '2007-12-24',
        'childgender'     =>  'MALE',
        'childemail'      =>  '',
        'childphotopath' => $childphotopath,
        'simblingList' =>  '',
        'hasinsurancecover' =>  1,
        'school_id' => $school->id,
        'schoolyear_id' => $schoolyear1->id,
        'schoolstate' => $school->state,
        'parentfirstname' => 'Parent',
        'parentlastname' => $lastname,
        'parentaddress' => 'MON ADRESS, 75000 PARIS',
        'parenthomephone' => '+33201010101',
        'parentmobile' => '+33601010101',
        'parentemail' => 'parentTwins@' . env('APP_DOMAIN'),
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

    $imagePath = public_path('/assets/images/avatar4.jpg');
    $image_base64 = base64_encode(file_get_contents($imagePath, true));
    $childphotopath = 'data:image/jpg;base64,' . $image_base64;

    Application::create(
      [
        'rallye_id'       =>  $stdrallye1->id,
        'childfirstname'  =>  'Enfant2',
        'childlastname'   =>   $lastname,
        'childbirthdate'  =>  '2007-12-24',
        'childgender'     =>  'MALE',
        'childemail'      =>  '',
        'childphotopath' => $childphotopath,
        'simblingList' =>  '',
        'hasinsurancecover' =>  1,
        'school_id' => $school->id,
        'schoolyear_id' => $schoolyear1->id,
        'schoolstate' => $school->state,
        'parentfirstname' => 'Parent',
        'parentlastname' => $lastname,
        'parentaddress' => 'MON ADRESS, 75000 PARIS',
        'parenthomephone' => '+33201010101',
        'parentmobile' => '+33601010101',
        'parentemail' => 'parentTwins@' . env('APP_DOMAIN'),
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
