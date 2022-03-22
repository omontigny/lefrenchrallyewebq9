@extends('layout.master')
@section('title', 'Edit School Year')
@section('parentPageTitle', 'Admin')
@section('page-style')
@stop
@section('content')
<div class='container'>
{{ Form::open(['method' => 'GET', 'url' => route('schoolyears.update', $schoolYear->id) ]) }}
@csrf
	<div class="form-group">
    {{form::label('current_level', 'Current school year title')}}
    {{form::text('current_level', $schoolYear->current_level, ['class' => 'form-control', 'placeholder' => 'School year title'])}}
  </div>
  <div class="form-group">
    {{form::label('next_level', 'Next School year title')}}
    {{form::text('next_level', $schoolYear->next_level, ['class' => 'form-control', 'placeholder' => 'School year title'])}}
  </div>
   {{form::submit('Submit', ['class' => 'btn btn-primary'])}}
   <a href="/schoolyears" class="btn btn-default float-right">Go back </a>
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