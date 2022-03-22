@extends('layout.master')
@section('title', 'Adding Parent to groups')
@section('parentPageTitle', 'Admin')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/multi-select/css/multi-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-spinner/css/bootstrap-spinner.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/nouislider/nouislider.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/select2/select2.css')}}">
@stop
@section('content')
<div class='container'>
{{ Form::open(['action' => ['ParentEventsController@update', $parentEvent->id], 'method' => 'POST']) }}
@csrf
{{Form::hidden('_method', 'PUT')}}
                
    <div class="form-group form-float"> 
        <label for="parent_id"><b>Parent</b></label>
        <select class="form-control show-tick ms select2" data-placeholder="Select" name="parent_id" required>
        <option value="" selected disabled>-- Please select a parent--</option>
          @foreach ($parents as $parent)
            <option value={{$parent->id}}
                @if ($parentEvent->parent->id === $parent->id)
                    selected
                @endif
                  >{{$parent->parentfirstname}} {{$parent->parentlastname}}</option>
          @endforeach
        </select>
        <div class="help-info"> 
        <p>Please select the targetted parent</p>
      </div>
    </div>

  <fieldset>                  
      <div class="form-group form-float"> 
        <label for="calendar_id"><b>Calendar</b></label>
        <select class="form-control show-tick ms select2" data-placeholder="Select" name="calendar_id" required>
        <option value="" selected disabled>-- Please select a rallye's event --</option>
          @foreach ($calendars as $calendar)
            <option value={{$calendar->id}}
                @if ($parentEvent->calendar->id === $calendar->id)
                    selected
                @endif
                  >{{$calendar->date_calendar}}</option>
          @endforeach
        </select>
        <div class="help-info"> 
        <p>Please select the targetted rallye's event</p>
      </div>
    </div>      
    
  {{form::submit('Add new', ['class' => 'btn btn-primary'])}}
  <a href="/rallyecoordinators" class="btn btn-default float-right">Go back </a>
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
<script>
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