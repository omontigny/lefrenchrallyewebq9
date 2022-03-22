@extends('layout.master')
@section('title', 'Edit a school')
@section('parentPageTitle', 'Admin')
@section('page-style')
@stop
@section('content')
<div class='container'>
  {{ Form::open(['method' => 'GET', 'url' => route('schools.update', $school->id) ]) }}
  @csrf
  <div class="form-group">
    {{form::label('name', 'Name')}}
    {{form::text('name', $school->name, ['class' => 'form-control', 'placeholder' => 'School name'])}}
  </div>
  <div class="form-group form-float">
    <label for="states">School system</label>
    <select class="form-control show-tick ms select2" data-placeholder="Select" name="state" required>
      <option value="English" @if($school->state === "English") selected @endif>English or other</option>
      <option value="French" @if($school->state === "French") selected @endif>French</option>
    </select>

    <div class="form-group">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="isApproved" name ="isApproved" value="true"
        @if ($school->approved)
                 checked
             @endif>
        <label class="form-check-label" for="isApproved">Approved</label>
      </div>
    </div>

  </div>
  {{form::submit('Submit', ['class' => 'btn btn-primary'])}}
  <a href="/schools" class="btn btn-default float-right">Go back </a>
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