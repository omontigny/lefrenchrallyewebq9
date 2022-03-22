@extends('layout.master')
@section('title', 'Create Rallye')
@section('parentPageTitle', 'Admin')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/multi-select/css/multi-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-spinner/css/bootstrap-spinner.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/nouislider/nouislider.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/select2/select2.css')}}">

<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/plugins/dropzone/dropzone.css')}}">

<link href="{{secure_asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
<link href="{{secure_asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet">

@stop
@section('content')
@if(count($rallyes) > 0)
<div class='container'>
{{ Form::open(['action' => 'SmallGroupsController@store', 'method' => 'GET']) }}
@csrf
  <div class="form-group form-float">
  <label for="rallye_id"><b>Rallye</b></label>
  <select class="form-control show-tick ms select2" data-placeholder="Select" name="rallye_id">
    <option value="" selected disabled>-- Please select a rallye --</option>
    @foreach ($rallyes as $rallye)
    @if($rallye->status)
        <option value={{$rallye->id}}>{{$rallye->title}}</option>
      @endif
    @endforeach
  </select>
  <div class="help-info">
  <!--
    <p>The rallyes above are (<b>Petit Rallye(s)</b>) and having status: Opened</p>
    <p>If you want to create RED/GROUP for example, please choose your targetted rallye</p>
  -->
  </div>


	<div class="form-group">
      <label for="name"><b>Group name</b></label>
    {{form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Group name'])}}
  </div>
  <div class="form-group">
    <label for="name"><b>Event date</b></label>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="zmdi zmdi-calendar"></i>
        </span>
        <input type="text" id="date" name="eventDate" class="form-control floating-label" placeholder="Date">
        
    </div>
    <div class="help-info">If you want to create RED/GROUP for example and you are working on rallye(Petit Rallye), you do not need to specify a date</div>
</div>

  <a href="/smallgroups" class="btn btn-default float-right">Go back </a>
  {{form::submit('Add new', ['class' => 'btn btn-primary'])}}
{{ Form::close() }}
</div>
 @else
        <p> No rallyes found </p>
        <a href={{secure_url("/rallyes/create")}}><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> Add new</button></a>
    @endif

@stop
@section('page-script')
<script src="{{secure_asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
<script src="{{secure_asset('assets/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-spinner/js/jquery.spinner.js')}}"></script>
<script src="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<script src="{{secure_asset('assets/plugins/nouislider/nouislider.js')}}"></script>
<script src="{{secure_asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>

<script src="{{secure_asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{secure_asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>

<script>
    $(function() {              
           // Bootstrap DateTimePicker v4
           
           $('#date').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY', weekStart : 0, time: false });
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