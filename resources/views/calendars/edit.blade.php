@extends('layout.master')
@section('title', 'Edit date calendar')
@section('parentPageTitle', 'Admin')
@section('page-style')
@stop
@section('content')
<div class='container'>
{{ Form::open(['action' => ['CalendarsController@update', $calendar->id], 'method' => 'POST']) }}
@csrf
	<div class="form-group">
    {{form::label('date_calendar', 'Date')}}
    {{form::date('date_calendar', $calendar->date_calendar, ['class' => 'form-control', 'placeholder' => 'DD/MM/YYYY'])}}
  </div>
  <div class="form-group form-float"> 
    <label for="rallye_id"><b>Rallye</b></label>
    <select class="form-control show-tick ms select2" data-placeholder="Select" name="rallye_id" required>
    <option value="" selected disabled>-- Please select a rallye --</option>
      @foreach ($rallyes as $rallye)
          <option value={{$rallye->id}}
          @if ($calendar->rallye->id === $rallye->id)
              selected
          @endif
            >{{$rallye->title}}</option>
       @endforeach
    </select>
  </div>
  {{Form::hidden('_method', 'PUT')}}
  {{form::submit('Submit', ['class' => 'btn btn-primary'])}}
{{ Form::close() }}
</div>
@stop
@section('page-script')
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