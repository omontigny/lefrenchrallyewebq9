@extends('layout.master')
@section('title', 'Managing Application')
@section('parentPageTitle', 'Admin')
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

<div class="container-fluid profile-page">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12">
            <div class="card profile-header bg-dark">
                <div class="body col-white">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="profile-image float-md-right"><img
                                src="{{$application->childphotopath}}"
                                    alt="" width="35" class="rounded-circle">
                                 </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-12">
                            <h4 class="m-t-0 m-b-0"><strong>{{$application->childlastname}}</strong>
                                {{$application->childfirstname}} <a href="/applicationrequests/editphoto/{{$application->id}}"><button type="button"
                                    class="btn btn-warning btn-sm"><span
                                        class="glyphicon glyphicon-pencil"></span></button></a></h4>
                            <span class="job_post">{{$application->rallye->title}}</span>

                            @if($application->is_boarder)
                            <span class="badge badge-dark">Boarder</span>
                            @endif
                            @switch($application->status)
                            @case(0)
                            <span class="badge badge-danger">Application</span>
                            @break
                            @case(1)
                            <span class="badge badge-success">Member</span>
                            @break
                            @case(2)
                            @break
                            @case(3)
                            <span class="badge badge-warning">Waiting list</span>
                            @break
                            @case(4)
                            <span class="badge badge-info">Aproved</span>
                            @break
                            @case(5)
                            <!--<td><strong>Ready</strong></td>-->
                            @break
                            @case(9)
                            <span class="badge badge-danger">Rejected</span>
                            @break
                            @endswitch
                            <div>
                                <!-- RESET PARENT PASSWORD ---------------------------------------------------------------------------- -->
                                @if($application->status == 1)
                                <button type="button" class="btn btn-primary btn-sm  " data-toggle="modal"
                                data-target="#ResetParentPasswordModal_{{$application->id}}"><span
                                    class="glyphicon glyphicon-repeat"></span> RESET PWD</button>
@endif
@if($application->status == 4)
<a href="/MailsController/{{$application->id}}/membershipConfirmedEmail"><button type="button"
    class="btn btn-primary btn-sm"><span
        class="glyphicon glyphicon-ok"></span>Confirm membership</button></a>
@endif
                                <a href="/applicationrequests" class="btn btn-default float-right">Go back </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- +AJO : Model section begin -->
    <div class="modal fade" id="ResetParentPasswordModal_{{$application->id}}"
        tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title text-center" id="defaultModalLabel">Reset parent's password
                    </h4>
                </div>

                <div class="modal-body">
                    {{ Form::open(['action' => 'ApplicationRequestsExtraController@ResetParentPassword', 'method' => 'GET']) }}

                    @csrf

                    <p for=""><b>Child : </b>{{$application->childfirstname}}
                        {{$application->childlastname}}</p>
                    <p for=""><b>Parent: </b>{{$application->parentfirstname}}
                        {{$application->parentlastname}}</p>
                    <p for=""><b>Rallye: </b>{{$application->rallye->title}}</p>
                    <p class="text-danger"><strong>Are you sure you want to reset this parent's password?</strong></p>
                    <div class="form-group form-float">

                    <input name="application_id" type="hidden"
                        value="{{$application->id}}">
                    <div class="modal-footer">
                        {{form::submit('Reset PWD', ['class' => 'btn btn-primary'])}}
                        <button type="button" class="btn btn-default float-right"
                            data-dismiss="modal">Cancel</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <!-- END MODAL-->
    </div>
</div>
<!-- RESET PARENT PASSWORD ---------------------------------------------------------------------------- -->

    <div class='container'>
        {{ Form::open(['method' => 'GET', 'url' => route('applicationrequests.update', $application->id) ]) }}
        @csrf

        <!-- Masked Input -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Application</strong> Management</h2>
                        @if($application->status != 9)
                        @if($application->status != 1 && $application->previous_status != 1
                            && $application->status != 4 && $application->previous_status != 4)
                        <a href="/applicationrequests/{{$application->id}}/approveApplicationById"><button type="button"
                                class="btn btn-primary btn-sm"><span
                                    class="glyphicon glyphicon-check"></span></button></a>

                                        @endif
                        <a href="/applicationrequests/{{$application->id}}/waiteApplicationById"><button type="button"
                                class="btn btn-warning btn-sm"><span
                                    class="glyphicon glyphicon-pause"></span></button></a>

                        @else
                        <a href="/applicationrequests/{{$application->id}}/deBlockingApplicationById"><button
                            type="button" class="btn btn-success btn-sm"><span
                                class="glyphicon glyphicon-ok-sign"></span></button></a>
                        @endif
                        @if($application->status == 1)


                    @endif

                    <button type="button" class="btn btn-danger btn-sm float-right" data-toggle="modal" data-target="#DeletingApplication_{{$application->id}}"><span class="glyphicon glyphicon-remove"></span></button>

                    </div>

                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6">
                                <label for="rallye_id"><b>Rallye</b></label>
                                <select class="form-control show-tick ms" data-placeholder="Select"
                                    name="rallye_id" required>
                                    <option value="" selected disabled>-- Please select a rallye --</option>
                                    @foreach ($rallyes as $rallye)
                                    <option value={{$rallye->id}} @if ($application->rallye->id === $rallye->id)
                                        selected
                                        @endif
                                        >{{$rallye->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_boarder" name="is_boarder"
                                        @if($application->is_boarder)
                                    value="true" checked
                                    @else
                                    value="false"
                                    @endif
                                    >
                                    <label class="form-check-label" for="is_boarder"><b>Boarder request</b></label>
                                </div>
                            </div>
                        </div>
                        <div class="demo-masked-input">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-6"> <b>Child first name</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ex: child first name"
                                            name="childfirstname" value="{{$application->childfirstname}}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6"> <b>Child last name</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ex: child last name"
                                            name="childlastname" value="{{$application->childlastname}}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6"> <b>Child birth date</b>
                                    <div class="input-group">
                                        <input type="text" id="date" name="childbirthdate" value="{{\Illuminate\Support\Carbon::parse($application->childbirthdate)->format('d/m/Y')}}" class="form-control floating-label" placeholder="Date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6"> <b>Child gender</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ex: Female/Male"
                                            name="childgender" value="{{$application->childgender}}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6"> <b>Simbling</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            placeholder="Simblings" name="simblingList"
                                            value="{{$application->simblingList}}">
                                    </div>
                                </div>
                                <div class="form-group form-float col-lg-3 col-md-6">
                                    <label for="school_id"><b>School</b></label>
                                    <select class="form-control show-tick ms select2" data-placeholder="Select"
                                        name="school_id" required>
                                        <option value="" selected disabled>-- Please select a school --</option>
                                        @foreach ($schools as $school)
                                        <option value={{$school->id}} @if ($application->school->id === $school->id)
                                            selected
                                            @endif
                                            >{{$school->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group form-float  col-lg-3 col-md-6">
                                    <label for="schoolState"><b>State</b></label>
                                    <select class="form-control show-tick ms" data-placeholder="Select" name="schoolState" required>
                                      <option value="" selected disabled>-- Please select a school system --</option>
                                        <option value="ENGLISH"
                                        @if ($application->schoolstate === 'ENGLISH')
                                        selected
                                        @endif
                                        >English or other</option>
                                        <option value="FRENCH"
                                        @if ($application->schoolstate === 'FRENCH')
                                        selected
                                        @endif
                                        >French</option>
                                  </select>
                                  </div>

                                <div class="form-group form-float col-lg-3 col-md-6">
                                    <label for="schoolyear_id"><b>School Year in September {{\Illuminate\Support\Carbon::now()->format('Y')}}</b></label>
                                    <select class="form-control show-tick ms" data-placeholder="Select"
                                        name="schoolyear_id" required>
                                        <option value="" selected disabled>-- Please select a school --</option>
                                        @foreach ($schoolyears as $schoolyear)
                                        <option value={{$schoolyear->id}} @if ($application->schoolyear->id ===
                                            $schoolyear->id)
                                            selected
                                            @endif
                                            >{{$schoolyear->current_level}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6"> <b>Preferred member 1</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ex: member full name"
                                            name="preferredmember1" value="{{$application->preferredmember1}}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6"> <b>Preferred member 2</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ex: member full name"
                                            name="preferredmember2" value="{{$application->preferredmember2}}">
                                    </div>
                                </div>

                            <div class="col-lg-3 col-md-6"> <b>Preferred date 1</b>
                                <div class="form-group">
                                    <input type="text" id="date1" name="preferreddate1" value="{{\Illuminate\Support\Carbon::parse($application->preferreddate1)->format('d/m/Y')}}" class="form-control floating-label" placeholder="Date">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6"> <b>Preferred date 2</b>
                                <div class="form-group">
                                    <input type="text" id="date2" name="preferreddate2" value="{{\Illuminate\Support\Carbon::parse($application->preferreddate2)->format('d/m/Y')}}" class="form-control floating-label" placeholder="Date">
                                </div>
                            </div>
                                <div class="col-lg-3 col-md-6"> <b>Parent first name</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            placeholder="Parent first name" name="parentfirstname"
                                            value="{{$application->parentfirstname}}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6"> <b>Parent last name</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            placeholder="Parent last name" name="parentlastname"
                                            value="{{$application->parentlastname}}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6"> <b>Address</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            placeholder="Address" name="parentaddress"
                                            value="{{$application->parentaddress}}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6"> <b>Home phone</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ex: +332123456789"
                                            name="parenthomephone" value="{{$application->parenthomephone}}" pattern="^(?:(?:\+|00)(33|44))\s*[1-9](?:[\s.-]*\d{2,}){4}$">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6"> <b>Mobile</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Ex: +336123456789"
                                            name="parentmobile" value="{{$application->parentmobile}}" pattern="^(?:(?:\+|00)(33|44))\s*[1-9](?:[\s.-]*\d{2,}){4}$">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6"> <b>Parent email</b>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            placeholder="Ex: example@example.com" name="parentemail"
                                            value="{{$application->parentemail}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="applicationID" name="applicationID" value="{{$application->id}}">
                        {{form::submit('Submit', ['class' => 'btn btn-primary'])}}
                        <a href="/applicationrequests" class="btn btn-default float-right">Go back </a>
                        {{ Form::close() }}
<hr/>

<h4>The Code of Conduct</h4>
<div class="form-group form-float ">
    <label for="signingcodeconduct" class="control-label col-xs-12" style="font-size:16px">My child has read and
      agreed to abide by the Rallye <a href="https://www.lefrenchrallye.com/about">Code of Conduct</a></label>
    <input value ="{{$application->signingcodeconduct}}" type="text" name="signingcodeconduct" placeholder="Please sign here" class="form-control" readonly>

  </div>

<h4>Data protection policy et terms and conditions</h4>
<div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="hasinsurancecover" name ="hasinsurancecover" value="true"
      @if ($application->hasinsurancecover)
               checked
           @endif disabled readonly>
      <label class="form-check-label" for="hasinsurancecover">I confirm that my child has personal accident and liability insurance cover valid for Le French Rallye activities. This is mandatory for the application to be submitted.</label>
    </div>
  </div>



<div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="dpp1" name ="dpp1" value="true"
      @if ($application->dpp1)
               checked
           @endif disabled readonly>
      <label class="form-check-label" for="dpp1">I have read and approve The French Rallye Data Protection Policy above.</label>
    </div>
  </div>

  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="dpp2" name ="dpp2" value="true"
      @if ($application->dpp2)
               checked
           @endif disabled readonly>
      <label class="form-check-label" for="dpp2">I solemnly commit only to use other Members personal data for the purpose of The French Rallye. I solemnly commit not to share other Members personal data with third parties.</label>
    </div>
  </div>

  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="otc1" name ="otc1" value="true"
      @if ($application->otc1)
               checked
           @endif disabled readonly>
      <label class="form-check-label" for="otc1">I confirm that my child has personal accident and liability insurance cover valid for Le French Rallye activities. This is mandatory for the application to be submitted.</label>
    </div>
  </div>

  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="otc2" name ="otc2" value="true"
      @if ($application->otc2)
               checked
           @endif disabled readonly>
      <label class="form-check-label" for="otc2">No change in family circumstances can be accepted as a reason to leave the Rallye before my Event date and I am committed financially towards the other Members hosting the Event.</label>
    </div>
  </div>



                    </div>

                </div>

            </div>

        </div>
        <!-- #END# Masked Input -->

    </div>

    <!-- +AJO : Model section begin -->
    <div class="modal fade" id="DeletingApplication_{{$application->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content bg-danger">
            <div class="modal-header">
            <h4 class="title col-white text-center" id="defaultModalLabel">Delete Application</h4>
            </div>
            <div class="modal-body col-white">
                {{ Form::open(['method' => 'GET', 'url' => route('applicationrequests.destroy', $application->id)]) }}
            @csrf

            <p for=""><b>Child : </b>{{$application->childfirstname}} {{$application->childlastname}}</p>
            <p for=""><b>Parent: </b>{{$application->parentfirstname}} {{$application->parentlastname}}</p>
            <p for=""><b>Rallye: </b>{{$application->rallye->title}}</p>

            <div class="form-group">
                <label for="action"><b>Are you sure you want to delete this application ?</b></label>
            </div>
            </div>
            {{Form::hidden('_method', 'DELETE')}}
            <div class="modal-footer">
            <button type="submit" class="btn btn-link waves-effect col-white">Yes</button>
            <button type="button" class="btn btn-link waves-effect col-white" data-dismiss="modal">No,
                cancel</button>
            </div>
            {{ Form::close() }}
        </div>
        </div>
    </div>
    <!-- END MODAL-->
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
