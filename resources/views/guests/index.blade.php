@extends('layout.master')
@section('title', 'Apply')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}"/>
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}"/>
@stop
@section('content')
<h3><span class="glyphicon glyphicon-user"></span> Extra Guests</h3>
<hr>
<p> </p>
<ol>
  <li>A children can invite extra guest .</li>
  <li>About 10 extra guest in total per year and per rallye.</li>
  <li>One extra guest can participate only twice a year .</li>
</ol>
<hr>
<h3>Add extra Guest</h3>
<p>Below, you can enter the information about the guest </p>
<div class='container'>
  {{ Form::open(['action' => 'guestsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
  @csrf
  <div class="form-group form-float">
    <label for="calendar_id"><b>Event date available</b></label>
     <select class="form-control show-tick ms select2" data-placeholder="Select" name="calendar_id" required>
      @if(count($availableGroupIds) > 0)
        <option value="" selected disabled>-- Please select a group - event date --</option>
        @foreach ($groups as $group)
          @foreach($availableGroupIds as $availableGroupId)
              @if($group->id == $availableGroupId)
                <option value={{$group->id}}>{{$group->rallye->title . ' ' . $group->name . ' ' . \Illuminate\Support\Carbon::parse($group->eventDate)->format('d-m-Y')}}</option>
              @endif
          @endforeach
        @endforeach
      @else
        <option value="" selected disabled>-- No event date available --</option>
      @endif
    </select>
  </div>

  <div class="form-group form-float">
    <label for="first_name"><b>First Name</b></label>
    {{form::text('first_name', '', ['class' => 'form-control', 'placeholder' => 'First Name'])}}
  </div>

   <div class="form-group form-float">
    <label for="last_name"><b>Last Name</b></label>
    {{form::text('last_name', '', ['class' => 'form-control', 'placeholder' => 'Last Name'])}}
  </div>

  <div class="form-group form-float">
    <label for="guest_email"><b>Email</b></label>
    {{form::text('guest_email', '', ['class' => 'form-control', 'placeholder' => 'name@domain.com'])}}
  </div>

  <div class="form-group form-float">
    <label for="guest_mobile"><b>Guest Mobile Phone</b></label>
    {{form::text('guest_mobile', '', ['class' => 'form-control', 'placeholder' => '+33122334455'])}}
  </div>

  <a href="/home" class="btn btn-default float-right">Go back </a>
  {{form::submit('Add Extra Guest', ['class' => 'btn btn-primary'])}}
  {{ Form::close() }}
</div>
<hr>

@stop
@section('page-script')
<script src="{{secure_asset('assets/js/pages/forms/form-fileSize-validation.js')}}"></script>

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
