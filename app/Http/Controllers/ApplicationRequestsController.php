<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Mailgun\Mailgun;
use App\Models\Rallye;
use App\Models\Application;
use App\Models\School;
use App\Models\Schoolyear;
use App\Models\Parents;
use App\Models\Children;
use App\Models\Admin_Rallye;
use App\Models\Parent_Rallye;
use App\Models\Role_User;
use App\Models\Invitation;
use App\Models\CheckIn;
use App\Models\Role;
use App\Models\Payment;
use App\Models\Coordinator_Rallye;
use App\Models\Coordinator;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Repositories\EmailRepository;
use App\Repositories\ImageRepository;

class ApplicationRequestsController extends Controller
{

  protected $emailRepository;
  protected $imageRepository;

  public function __construct(EmailRepository $emailRepository, ImageRepository $imageRepository)
  {
    // if user is not identified, he will be redirected to the login page
    // $this->middleware('auth');
    // TODO: CHeck if the apply mode is activated
    $this->emailRepository = $emailRepository;
    $this->imageRepository = $imageRepository;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {

      $girls = null;
      $boys = null;
      $englishs = null;
      $frenchs = null;
      $appReceived = null;
      $appWaitingList = null;
      $appApproved = null;
      $appMembered = null;

      $payments = null;
      $rallye_id = null;
      $applications = null;

      if (Auth::user()->active_profile == config('constants.roles.COORDINATOR')) {
        $coordinator = Coordinator::where('user_id', Auth::user()->id)->get()->first();
        if ($coordinator != null) {
          $coordinatorRallye = Coordinator_Rallye::where('coordinator_id', $coordinator->id)
            ->where('active_rallye', '1')->first();

          if ($coordinatorRallye != null) {
            $rallye_id = $coordinatorRallye->rallye->id;
          }
        }
      } else if (Auth::user()->active_profile == config('constants.roles.SUPERADMIN')) {
        $adminRallye = Admin_Rallye::where('user_id', Auth::user()->id)
          ->where('active_rallye', '1')->first();

        if ($adminRallye != null) {
          $rallye_id = $adminRallye->rallye->id;
        }
      }

      if ($rallye_id != null) {
        $girls        = count(Application::where('rallye_id', $rallye_id)->where('childgender', 'FEMALE')->get());
        $boys         = count(Application::where('rallye_id', $rallye_id)->where('childgender', 'MALE')->get());
        $englishs     = count(Application::where('rallye_id', $rallye_id)->where('schoolstate', 'ENGLISH')->get());
        $frenchs      = count(Application::where('rallye_id', $rallye_id)->where('schoolstate', 'FRENCH')->get());
        $applications = Application::where('rallye_id', $rallye_id)->get();

        $appReceived    = count(Application::where('rallye_id', $rallye_id)->where('status', 0)->get());
        $appWaitingList = count(Application::where('rallye_id', $rallye_id)->where('status', 3)->get());
        $appApproved    = count(Application::where('rallye_id', $rallye_id)->where('status', 4)->get());
        $appMembered    = count(Application::where('rallye_id', $rallye_id)->where('status', 1)->get());
        $payments       = Payment::where('rallye_id', $rallye_id)->get();
      }

      $rallyes = Rallye::oldest('title')->get();

      $data = [
        'rallyes'   => $rallyes,
        'applications' => $applications,
        'girls' => $girls,
        'boys' => $boys,
        'frenchs' => $frenchs,
        'englishs' => $englishs,
        'appReceived' => $appReceived,
        'appWaitingList' => $appWaitingList,
        'appApproved' => $appApproved,
        'appMembered' => $appMembered,
        'payments' => $payments
      ];

      return view('applicationrequests.index')->with($data);
    } catch (Exception $e) {
      return Redirect::back()->withError('E034: ' . $e->getMessage());
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    try {

      $rallyes = Rallye::oldest('title')->get();
      return view('applicationrequests.create')->with('rallyes', $rallyes);
    } catch (Exception $e) {
      return Redirect::back()->withError('E035: ' . $e->getMessage());
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      //
      $this->validate($request, [
        //Rules to validate
        'childfirstname' => 'required',
        'childlastname' => 'required',
        'rallye_id' => 'required'
      ]);
      try {
        // Creating an application
        $application = new Application();

        // rallye info
        $application->rallye_id  = $request->input('rallye_id');
        $application->is_boarder = ($request->has('is_boarder')) ? true : false;

        // child info
        $application->childfirstname  = ucwords(Str::lower($request->input('childfirstname')));
        $application->childlastname   = Str::upper($request->input('childlastname'));
        $application->childbirthdate  = $this->formatDateToMySQLFormat($request->input('childbirthdate'));
        $application->childgender     = Str::upper($request->input('childgender'));
        $application->childemail      = Str::upper($request->input('childemail'));
        $application->simblingList    = Str::upper($request->input('simblingList'));

        // Child Photo upload and resize
        // chek Valid file extensions
        $extensions_arr = ["png", "jpg", "jpeg"];
        $target_file = basename($_FILES["childphotopath"]["name"]);
        Log::stack(['single', 'stdout'])->debug('target_file: ' . $target_file);

        // Select file type
        $imageFileType = Str::lower(pathinfo($target_file, PATHINFO_EXTENSION));
        Log::stack(['single', 'stdout'])->debug('imageFileType: ' . $imageFileType);

        // if extension correct
        if (in_array($imageFileType, $extensions_arr)) {

          /**  Convert to base64 and resize picture **/
          $source_file = $_FILES['childphotopath']['tmp_name'];
          Log::stack(['single', 'stdout'])->debug("source file: " . $source_file);
          //$image_base64 = base64_encode(file_get_contents($source_file));

          // We do resize only if filesize > 150Ko
          if (filesize($source_file) > 152400) {

            $childphotoTempFolder = 'images/childphoto/';
            if (!Storage::disk('temp')->exists($childphotoTempFolder)) {
              Storage::disk('temp')->makeDirectory($childphotoTempFolder, 0777, true, true);
            };
            $destination_dir = Storage::disk('temp')->path($childphotoTempFolder); # storage/app/temp/images/childphoto/
            $destination_file = $destination_dir . $application->id . '_' . $target_file;

            Log::stack(['single', 'stdout'])->info("***** We have to resize this picture : " . $destination_file . "*********");
            $orientation = @exif_read_data($source_file)['Orientation']; // @ for silent warning exif_read_data(php3KLADx): File not supported for some png files
            Log::stack(['single', 'stdout'])->debug("exif orientation : $orientation");

            // resize image with a max value for width or height fixed to 500
            $this->imageRepository->resizeImage(
              $source_file,
              $destination_file,
              $imageFileType,
              500
            );
            // sometimes some pictures change orientation after resizing, that's why next step restoring correction orentation
            $rotatedFile = $this->imageRepository->rotateImageByExifOrientation($destination_file, $imageFileType, $orientation);
            if (is_resource($rotatedFile)) {
              imagejpeg($rotatedFile, $destination_file, 100);
            }
            Log::stack(['single', 'stdout'])->info("***** End Resize image *********");
          } else {
            $destination_file = $_FILES["childphotopath"]["tmp_name"];
          }

          // get base64 encoding of the new file to store in database
          $image_base64 = base64_encode(file_get_contents($destination_file, true));
          $image = 'data:image/' . $imageFileType . ';base64,' . $image_base64;

          // delete local tempory file
          if (!unlink($destination_file)) {
            Log::stack(['single', 'stdout'])->error("$destination_file cannot be deleted due to an error");
          } else {
            Log::stack(['single', 'stdout'])->info("$destination_file has been correctly deleted");
          }
          /** end convert with resize **/

          /**  Convert to base64 without resize picture **/
          // $image_base64 = base64_encode(file_get_contents($_FILES['childphotopath']['tmp_name']));
          // $image = 'data:image/' . $imageFileType . ';base64,' . $image_base64;

          // Put the new image in the childphotopath field of the model
          $application->childphotopath = $image;
          $application->extension = $imageFileType;
        } else {
          return Redirect::back()->withError('E254: Only .png, jpg, jpeg extensions that are accepted.');
        }

        if ($request->has('hasinsurancecover')) {
          $application->hasinsurancecover = true;
        }

        // parent info
        $application->parentfirstname  = ucwords(Str::lower($request->input('parentfirstname')));
        $application->parentlastname   = Str::upper($request->input('parentlastname'));
        $application->parentaddress    = Str::upper($request->input('parentaddress'));
        $application->parenthomephone  = $request->input('parenthomephone');
        $application->parentmobile     = $request->input('parentmobile');
        $application->parentemail      = Str::lower($request->input('parentemail'));

        $application->signingcodeconduct = Str::upper($request->input('signingcodeconduct'));

        if (strcmp($request->input('school_id'), "OTHER") != 0) {
          $application->school_id = $request->input('school_id');
        } else {
          $school = new School;
          $school->name = Str::upper($request->input('newSchool'));
          $school->state = Str::upper($request->input('schoolState'));
          $school->added_by = config('constants.roles.PARENT');
          $school->save();
          $application->school_id = $school->id;
        }
        $application->schoolstate = Str::upper($request->input('schoolState'));

        $application->schoolyear_id = $request->input('schoolyear_id');

        $application->preferredmember1 = $request->input('preferredmember1');
        $application->preferredmember2 = $request->input('preferredmember2');

        $application->preferreddate1 = $this->formatDateToMySQLFormat($request->input('preferreddate1'));
        $application->preferreddate2 = $this->formatDateToMySQLFormat($request->input('preferreddate2'));

        $application->signingcodeconduct = $request->input('signingcodeconduct');

        // dpp info
        $application->dpp1 = ($request->has('dpp1')) ? true : false;
        $application->dpp2 = ($request->has('dpp2')) ? true : false;

        // otc info
        $application->otc1 = ($request->has('otc1')) ? true : false;
        $application->otc2 = ($request->has('otc2')) ? true : false;

        $application->save();
      } catch (QueryException $e) {
        Log::stack(['single'])->error("[APPLICATION REQUEST] - [store] : ça passe  pas !" .  $e->getMessage());
        /*
          0 => string '23000' (length=5)
          1 => int 1452
          2 => string 'Cannot add or update a child row: a foreign key constraint fails (...)
        */
        return redirect('/welcome')->withErrors('E001: Integrity constraint violation: 1062 Duplicate ');
      }

      // Your child is transferred from one rallye to another one

      //////////////////////////////////////////////////////////////////////
      // MAIL 01: Application received (SMTP)
      //////////////////////////////////////////////////////////////////////

      $data = ['application' => $application];

      $bcclist =  $application->parentemail;
      $bccnamelist = $application->parentfirstname;
      $bcclistmails = ['bccnamelist' => $bcclist];

      Mail::send('mails/applicationReceived', $data, function ($m) use ($application, $bcclistmails) {
        $m->from($application->rallye->rallyemail, env('APP_NAME'));
        $m->replyTo($application->rallye->rallyemail);
        $m->to($application->parentemail);
        $m->subject('[' . env('APP_NAME') . '] - Application received');
      });

      //////////////////////////////////////////////////////////////////////
      // MAIL 01: Application received (MailGun)
      //////////////////////////////////////////////////////////////////////
      // $data = array(
      //   'from'        => env('APP_NAME') . '<' . $application->rallye->rallyemail . '>',
      //   'subject'     => '[' . env('APP_NAME') . '] - Application received',
      //   'to'          => $application->parentlastname . " " . $application->parentfirstname . ' <' . $application->parentemail . '>',
      //   "h:Reply-To"  => $application->rallye->rallyemail,
      // );

      // $htmlData = array('application' => $application);
      // $html = view('mails/applicationReceived', $htmlData)->render();
      // $this->emailRepository->sendMailGun($data, $html);
      //////////////////////////////////////////////////////////////////////

      //Use CheckMailSent to log and check if sending OK
      $this->emailRepository->CheckMailSent($application->childfirstname . " " . $application->childlastname, [], "applicationReceived", "Guest");

      return redirect('/welcomeRequest')->with('success', 'M004: Your request application has been sent!');
    } catch (Exception $e) {
      Log::stack(['single', 'stdout'])->error("[APPLICATION FORM] - [MAILGUN Email] : ça passe  pas !" .  $e->getMessage());
      report($e);
      return Redirect::back()->withError('E036: ' . $e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }



  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  // public function edit($id)
  // {
  //   try {

  //     //
  //     $application = Application::find($id);
  //     $rallyes = Rallye::orderBy('title', 'asc')->get();
  //     $schools = School::orderBy('name', 'asc')->get();
  //     $schoolyears = Schoolyear::orderBy('id', 'asc')->get();
  //     $userDebug = $application->parentemail;
  //     $data = [
  //       'application' => $application,
  //       'rallyes'   => $rallyes,
  //       'schools'   => $schools,
  //       'schoolyears'   => $schoolyears,
  //       'userDebug' => $userDebug
  //     ];

  //     return view('applicationrequests.edit')->with($data);
  //   } catch (Exception $e) {
  //     return Redirect::back()->withError('E037: ' . $e->getMessage());
  //   }
  // }




  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function resetParentPassword($id)
  {
    try {
    } catch (Exception $e) {
      Log::stack(['single', 'stdout'])->debug("[EXCEPTION] - [PARENT RESET PASSWORD] " . $e->getMessage());
      return Redirect::back()->withError('E039: ' . $e->getMessage());
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  date  $date
   * @return $result : new date format
   */
  private function formatDateToMySQLFormat($date)
  {
    $result = null;
    if ($date != null) {
      $result =  Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }
    return $result;
  }
}
