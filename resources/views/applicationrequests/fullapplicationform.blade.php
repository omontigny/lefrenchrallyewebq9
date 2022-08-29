@extends('layout.master')
@section('title', 'Application')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/plugins/dropzone/dropzone.css')}}">

<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/multi-select/css/multi-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-spinner/css/bootstrap-spinner.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/nouislider/nouislider.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/select2/select2.css')}}">

<link href="{{secure_asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
<link href="{{secure_asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet">


@stop
@section('content')
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="body">
        {{ Form::open(['action' => 'ApplicationRequestsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
        {{-- @csrf --}}
        <hr />
        <h3 class="text-center">Rallye</h3>
        <hr />
        <fieldset>
          <div class="form-group form-float">
            <label for="rallye_id"><b>Rallye<span class="text-danger"> *</span></b></label>
            <select class="form-control show-tick ms" data-placeholder="Select" name="rallye_id" required>
              <option value="" selected disabled>-- Please select a rallye --</option>
              @foreach ($rallyes as $rallye)
              @if($rallye->status)
              <option value={{$rallye->id}}>{{$rallye->title}}</option>
              @endif
              @endforeach
            </select>

            <div class="help-info">
              <h5>How to choose which Rallye to apply for:</h5>
              <p>If your son/daughter was a member of Le French Rallye last year, they should apply for the same Rallye.
                For example: If last year your child was part of Rallye Mayfair 2018-2019, you should apply for Rallye
                Mayfair 2019-2020.</p>
              <p>If your son/daughter is joining for the first time, please make sure you have fully read through the
                <a href="https://www.lefrenchrallye.com/about">About Page</a> before you fill out your application. There, you will find information about the different
                age categories and Rallyes. If you need additional information, please contact us by email. (Email
                addresses can be found on the <a href="https://www.lefrenchrallye.com/contact">contact page</a>.)</p>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_boarder" name="is_boarder" value="false">
              <label class="form-check-label" for="is_boarder"><b>Full Boarder request</b></label>
            </div>
            <hr />
            <h6 class="text-center">Enter Child Information</h6>
            <hr />
            <fieldset>
              <div class="row clearfix">
                <div class="form-group form-float col-md-6">
                  <label for=""><b>First name<span class="text-danger"> *</span></b></label>
                  <input type="text" name="childfirstname" placeholder="First Name *" class="form-control" required>
                  <div class="help-info">You need to enter your child's first name.</div>
                </div>
                <div class="form-group form-float col-md-6">
                  <label for=""><b>Last name<span class="text-danger"> *</span></b></label>
                  <input type="text" name="childlastname" placeholder="Last Name *" class="form-control" required>
                  <div class="help-info">You need to enter your child's last name.</div>
                </div>
              </div>

              <!--<div class="body">
                <div class="demo-masked-input">
                  <div class="row clearfix">
                    <div class="col-lg-3 col-md-6"> <b>Child birth date</b>
                      <div class="input-group" id="datetimepicker4">
                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i> </span>
                        <input type="text" name="childbirthdate" class="form-control date" placeholder="Ex: 30/07/2016">
                        <div class="help-info">You need to enter your child's date of birth. </div>
                      </div>
                    </div>
                  </div>


                </div>
              </div>
            -->
            <div class="col-lg-3 col-md-6"> <b>Child birth date<span class="text-danger"> *</span></b>
              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="zmdi zmdi-calendar"></i>
                  </span>
                  <input type="text" id="date" name="childbirthdate" class="form-control floating-label" placeholder="Date" required>
                  <div class="help-info">select your child date of birth in the calendar </div>
              </div>
          </div>


              <!-- Group of default radios - Female -->
              <div class="form-group">
                <label for=""><b>Gender <span class="text-danger"> *</span></b></label>
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" id="Female" value="Female" name="childgender" required>
                  <label class="custom-control-label" for="Female">Female</label>
                </div>

                <!-- Group of default radios -  Male -->
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" id="Male" value="Male" name="childgender" checked>
                  <label class="custom-control-label" for="Male">Male<label>
                </div>
              </div>
              <!--
              <div class="form-group form-float ">
                <label for=""><b>Email</b></label>
                <input type="email" name="childemail" placeholder="Your child's email"
                  class="form-control">
                <div class="help-info">
                  <p>You may want to enter your child's email address so that they can recieve a copy of the party
                    invitations.</p>
                  <p>By entering in your child's email address, you authorize Le French Rallye to send invitations to
                    your child via email. <strong>They will not be able to respond, it is for information only.</strong>
                </div>
              </div>
            -->
              <div class="form-group form-float">
                <label for="simblingList"><b>Siblings in the French Rallye</b></label>
                <input type="text" name="simblingList"
                  placeholder="Sibling in the rallye (Ex: Adam Jans, Katie Rigault)" class="form-control">
                <div class="help-info">When possible, priority will be given to siblings.</div>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="hasinsurancecover" name="hasinsurancecover"
                  value="true" required>
                <label class="form-check-label" for="hasinsurancecover"><span class="text-danger">(*)</span> I confirm that my child has personal accident
                  and liability insurance cover valid for Le French Rallye activities. This is mandatory for the
                  application to be submitted.</label>
                <div class="help-info">You need to select that your child has personal accident and liability insurance.
                </div>
              </div>

              <div class="form-group form-float">
                <label for="school_id"><b>School to be attended this year<span class="text-danger"> *</span></b></label>
                <select class="form-control show-tick ms select2" data-placeholder="Select" name="school_id" required>
                  <option value="" selected disabled>-- Please select a school --</option>
                  @foreach ($schools as $school)
                  <option value={{$school->id}}>{{$school->name}}</option>
                  @endforeach
                  <option value="OTHER">OTHER</option>
                </select>
              </div>

              <div class="form-group form-float">
                <label for="newSchool"><b>Other school</b></label>
                <input type="text" name="newSchool" placeholder="School name" value="" class="form-control">
                <div class="help-info">other school not listed above, please specify it</div>
              </div>

              <div class="form-group form-float">
                <label for="schoolState"><b>School system<span class="text-danger"> *</span></b></label>
                <select class="form-control show-tick ms" data-placeholder="Select" name="schoolState" required>
                  <option value="" selected disabled>-- Please select a school system --</option>
                  <option value="English">English or other</option>
                  <option value="French">French</option>
                </select>
              </div>

              <div class="form-group form-float">
                <label for="schoolyear_id"><b>School Year in September {{\Illuminate\Support\Carbon::now()->format('Y')}}<span class="text-danger"> *</span></b></label>
                <select class="form-control show-tick ms" data-placeholder="Select" name="schoolyear_id"
                  required>
                  <option value="" selected disabled>-- Please select a school level --</option>
                  @foreach ($schoolyears as $schoolyear)
                  <option value={{$schoolyear->id}}>{{$schoolyear->current_level}}</option>
                  @endforeach
                </select>
                <div class="help-info">You need to select your child's current school year.</div>
              </div>

              <!-- Managing photo -->
              <div class="container-fluid">
                <div class="row clearfix">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                      <div class="body" class="dropzone">
                        <div class="dz-message">
                          <div class="drag-icon-cph"> <i class="material-icons">touch_app</i> </div>
                          <h3><span class="text-danger">(*)</span> Drop files here or click to your child picture.</h3>
                          <em>Please upload a photo of your child. It will be used for verifying their identity at the
                            entrance to parties. It must be in <strong>PNG, JPEG or JPG format</strong> and <font color='red'><em>no larger than 2Mb</em></font>. If
                            you are having trouble, please be patient as <strong><em>it can take a minute or two if you have a slow internet
                            connection</em></strong>. You can also try using a different web browser e.g. Google Chrome, Safari or
                            Mozilla Firefox. <br> If you are still having issues, please contact <a
                              href="mailto:webmaster@lefrenchrallye.com">webmaster@lefrenchrallye.com</a></em>
                        </div>
                        <div class="fallback">
                          <input name="childphotopath" id="file" type="file" onchange="Filevalidation()" multiple required /><span id="size"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Managing photo -->


            </fieldset>
            <fieldset>
              <hr />
              <h3 class="text-center">Preferences</h3>
              <hr />
              <div class="form-group form-float">
                <h4>Choose Preferred Members (optional)</h4>
                <div class="help-info">You can enter up to two other members with whom you would like to host.</div>
              </div>
              <div class="form-group form-float ">
                <label for="preferredmember1"><b>Preferred Member 1</b></label>
                <input type="text" name="preferredmember1" placeholder="Child name" class="form-control">
              </div>
              <div class="form-group form-float ">
                <label for="preferredmember2"><b>Preferred Member 2</b></label>
                <input type="text" name="preferredmember2" placeholder="Child name" class="form-control">
              </div>


              <div class="col-lg-3 col-md-6"> <b>Preferred date 1</b>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="zmdi zmdi-calendar"></i>
                    </span>
                    <input type="text" id="date1" name="preferreddate1" class="form-control floating-label" placeholder="Date">
                </div>
              </div>

                <div class="col-lg-3 col-md-6"> <b>Preferred date 2</b>
                  <div class="input-group">
                      <span class="input-group-addon">
                          <i class="zmdi zmdi-calendar"></i>
                      </span>
                      <input type="text" id="date2" name="preferreddate2" class="form-control floating-label" placeholder="Date">
                  </div>
                </div>
          </div>

        </fieldset>
        <fieldset>
          <hr />
          <h3 class="text-center">Parent info</h3>
          <hr />
          <div class="form-group form-float ">
            <label for="parentfirstname"><b>First name<span class="text-danger"> *</span></b></label>
            <input type="text" name="parentfirstname" placeholder="Your first name" class="form-control" required>
            <div class="help-info">
              <p>You need to enter your first name.</p>
            </div>
          </div>
          <div class="form-group form-float ">
            <label for=""><b>Last name<span class="text-danger"> *</span></b></label>
            <input type="text" name="parentlastname" placeholder="Your last name" class="form-control" required>
            <div class="help-info">
              <p>You need to enter your last name.</p>
            </div>
          </div>

          <div class="form-group form-float ">
            <label for=""><b>Your email<span class="text-danger"> *</span></b></label>
            <input type="mail" name="parentemail" placeholder="Your email" class="form-control" required>
            <div class="help-info">
              <p>You need to enter your email that will be used to sign in/ to stay in touch with the rally or to send
                invitations, reminders</p>
            </div>
          </div>

          <div class="form-group form-float ">
            <label for="parentaddress"><b>Address<span class="text-danger"> *</span></b></label>
            <input type="text" name="parentaddress" placeholder="address" class="form-control" required>
            <div class="help-info">
              <p>You need to enter your address.</p>
            </div>
          </div>

          <div class="form-group form-float ">
            <label for="parenthomephone"><b>Home phone</b></label>
            <input type="text" name="parenthomephone" placeholder="+XX123456789"
            pattern="^(?:(?:\+|00)(33|44|1))\s*[1-9](?:[\s.-]*\d{2,}){4}$"
            class="form-control">
            <div class="help-info">
              <p>You need to enter your home phone number.</p>
            </div>
          </div>

          <div class="form-group form-float ">
            <label for="parentmobile"><b>Mobile<span class="text-danger"> *</span></b></label>
            <input type="tel" name="parentmobile" placeholder="+XX123456789"
              pattern="^(?:(?:\+|00)(33|44|1))\s*[1-9](?:[\s.-]*\d{2,}){4}$" class="form-control" required>
            <div class="help-info">
              <p>You need to enter your mobile phone number.</p>
              <p>Examples: For France: +33613210343 | For England: +447595246359</p>
            </div>
          </div>
        </fieldset>
        <fieldset>
          <hr />
          <h3 class="text-center">Terms & conditions</h3>
          <hr />
          <div class="form-group form-float">
            <h4>Read &amp; Accept The Code of Conduct</h4>
          </div>
          <div class="row col-xs-12 ng-scope">
            <ol style="margin-bottom:30px">
              <li>I will reply to all invitations, and, forLe Petit Rallye, pay before the deadline.</li>
              <li>I will not bring any alcohol to events.</li>
              <li>I understand that regular at tendance of the events is essential to get to know other Members and
                create a successful party environment.</li>
              <li>I will dress appropriately for the activity and as recommended by the invitation.</li>
              <li>I will arrive on time for the events. In case of unforeseeable delay or absence, I will inform the
                HostParents. </li>
              <li>I will not leave the event without letting the Host Parents know and thanking them.</li>
              <li>I will show kindness, hospitality and respect for others.</li>
              <li>The use of drugs will lead to immediate exclusion from Le FrenchRallye.</li>
              <li>I will send a note to the hosting parents thanking them for the party.</li>
              <li>I will not publish or use photos of other people without their approval (Facebook, Instagram, blogs
                etc)</li>
            </ol>
          </div>
          <div class="form-group form-float ">
            <label for="signingcodeconduct" class="control-label col-xs-12" style="font-size:16px"><span class="text-danger">(*) </span>My child has read and
              agreed to abide by the Rallye Code of Conduct and Parents Charter (<a href="https://www.lefrenchrallye.com/about">Full version</a>)</label>
            <input type="text" name="signingcodeconduct" placeholder="Please enter “I accept” here" class="form-control" required>
            <div class="help-info">
              <p>You need to read and accept the code of conduct by entering “I accept” here.</p>
            </div>
          </div>
          <div class="form-group form-float">
          </div>
          <div class="form-group form-float">
            <h3>Data Protection Policy</h3>
            <p>The French Rallye Ltd recognises the importance of the correct and lawful collection and treatment of
              personal data. By submitting your details you acknowledge that your details will be added to The French
              Rallye database and be used solely for the purposes of the French Rallye ’s activities by the French
              Rallye and its members. We will only maintain such information as is necessary for the purpose of the
              French Rallye. Members will be informed of any breach of security that may be identified. Rallye Members
              will have their personal data permanently erased from the website at the end of their particular Rallye’s
              life, i.e. after the approvals of the accounts of the third year of their Rallye. Members can request at
              any time before that date for their personal data to be erased from the website by sending a written
              notification to its Directors. The data will be removed swiftly. Members commit to only using other Members’ personal data for the purpose of The French Rallye.
              Members commit to not sharing other Members personal data or photos with third parties.</p>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="dpp1" name="dpp1" value="true" required>
              <label class="form-check-label" for="dpp1"><span class="text-danger">(*) </span>I have read and approve The French Rallye Data Protection
                Policy above.</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="dpp2" name="dpp2" value="true" required>
              <label class="form-check-label" for="dpp2"><span class="text-danger">(*) </span>I solemnly commit not to share other members personal data
                (including photos) with third parties.</label>
            </div>

          </div>
          <div class="form-group form-float">
            <h4>Other Terms and Conditions</h4>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="otc1" name="otc1" value="true" required>
              <label class="form-check-label" for="otc1"><span class="text-danger">(*) </span>I confirm that my child has personal accident and liability
                insurance cover valid for Le French Rallye activities. This is mandatory for the application to be
                submitted.</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="otc2" name="otc2" value="true" required>
              <label class="form-check-label" for="otc2"><span class="text-danger">(*) </span>No change in family circumstances can be accepted as a reason
                to leave the Rallye before my Event date and I am committed financially towards the other Members
                hosting the Event.</label>
            </div>
            <!--<div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" disabled>
                    <label class="form-check-label" for="inlineCheckbox3">3 (disabled)</label>
                  </div>-->
          </div>

        </fieldset>
        <fieldset>
          <hr />
          <h3 class="text-center">Confirm & submit</h3>
          <hr />
        </fieldset>
        {{form::submit('Submit', ['class' => 'btn-block btn-primary'])}}
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@stop
@section('page-script')

<script src="{{secure_asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{secure_asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>


<script src="{{secure_asset('assets/plugins/dropzone/dropzone.js')}}"></script>
<script src="{{ secure_asset('assets/js/date-input-polyfill.dist.js') }}"></script>
<script src="{{secure_asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
<script src="{{secure_asset('assets/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-spinner/js/jquery.spinner.js')}}"></script>
<script src="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<script src="{{secure_asset('assets/plugins/nouislider/nouislider.js')}}"></script>
<script src="{{secure_asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/forms/form-fileSize-validation.js')}}"></script>

<script>
  $(function() {
           // Bootstrap DateTimePicker v4

           $('#date').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY', weekStart : 0, time: false });
           $('#date1').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY', weekStart : 0, time: false });
           $('#date2').bootstrapMaterialDatePicker({  format : 'DD/MM/YYYY', weekStart : 0, time: false });

        });

  /*global $ */
    $(document).ready(function() {
      "use strict";
      $('.menu > ul > li:has( > ul)').addClass('menu-dropdown-icon');
      //Checks if li has sub (ul) and adds class for toggle icon - just an UI

      $('.menu > ul > li > ul:not(:has(ul))').addClass('normal-sub');

      $(".menu > ul > li").hover(function(e) {
        if ($(window).width() > 943) {
          $(this).children("ul").stop(true, false).fadeToggle(150);
          e.preventDefault();
        }
      });
      //If width is more than 943px dropdowns are displayed on hover
      $(".menu > ul > li").on('click',function() {
        if ($(window).width() <= 943) {
          $(this).children("ul").fadeToggle(150);
        }
      });
      //If width is less or equal to 943px dropdowns are displayed on click (thanks Aman Jain from stackoverflow)

      $(".h-bars").on('click',function(e) {
        $(".menu > ul").toggleClass('show-on-mobile');
        e.preventDefault();
      });
      //when clicked on mobile-menu, normal menu is shown as a list, classic rwd menu story (thanks mwl from stackoverflow)
    });
</script>
@stop
