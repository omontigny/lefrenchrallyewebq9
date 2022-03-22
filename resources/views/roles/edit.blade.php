@extends('layout.master')
@section('title', 'Edit role')
@section('parentPageTitle', 'Admin')
@section('page-style')
@stop
@section('content')
<div class='container'>
{{ Form::open(['method' => 'GET', 'url' => route('roles.update', $role->id) ]) }}
@csrf
	<div class="form-group">
    {{form::label('rolename', 'Role name')}}
    {{form::text('rolename', $role->rolename, ['class' => 'form-control', 'placeholder' => 'Role name'])}}
  </div>
   {{form::submit('Submit', ['class' => 'btn btn-primary'])}}
   <a href="/roles" class="btn btn-default float-right">Go back </a>
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