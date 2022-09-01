@extends('layout.master')
@section('title', 'Edit Group')
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
<div class='container'>
  {{ Form::open(['method' => 'GET', 'url' => route('groups.update', $group->id) ]) }}
@csrf
	<div class="form-group">
    <b>{{form::label('name', 'Group name')}}<span class="text-danger"> *</span></b>
    {{form::text('name', $group->name, ['class' => 'form-control', 'placeholder' => 'Group name', 'required'])}}
  </div>

  <div class="form-group form-float">
    <label for="rallye_id"><b>Rallye<span class="text-danger"> *</span></b></label>
    <select class="form-control show-tick ms select2" data-placeholder="Select" name="rallye_id" required>
    <option value="" selected disabled>-- Please select a rallye --</option>
      @foreach ($rallyes as $rallye)
        @if(!$rallye->isPetitRallye)
          <option value={{$rallye->id}}
          @if ($group->rallye->id === $rallye->id)
              selected
          @endif
            >{{$rallye->title}}</option>
        @endif
       @endforeach
    </select>
  </div>

    <div class="form-group">
      <label for="name"><b>Event date<span class="text-danger"> *</span></b></label>
      <div class="input-group">
          <span class="input-group-addon">
              <i class="zmdi zmdi-calendar"></i>
          </span>
          <input type="text" id="date" value="{{\Illuminate\Support\Carbon::parse($group->eventDate)->format('d/m/Y')}}" name="eventDate" class="form-control floating-label" placeholder="Date">

      </div>
  </div>

   {{form::submit('Submit', ['class' => 'btn btn-primary'])}}
   <a href="/groups" class="btn btn-default float-right">Go back </a>
{{ Form::close() }}

</div>
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
