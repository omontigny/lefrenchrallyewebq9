@extends('layout.master')
@section('title', 'Home')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}"/>
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}"/>
@stop
@section('content')
<h2>Welcome to the French Rallye Member area!</h2>
<p>
  You can have access to your child invitations to events, reply to invitations, send your event invitation, manage
guest list and reminders and do the online check in art your event. <br>
You can also find here the contact details of other parents in your rallye or rallye group.
If you have any question, technical issue please contact your rallye coordinators.
</p>
@stop
@section('page-script')
<script src="{{secure_asset('assets/bundles/knob.bundle.js')}}"></script>
<script src="{{secure_asset('assets/bundles/morrisscripts.bundle.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/charts/jquery-knob.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/index2.js')}}"></script>
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
