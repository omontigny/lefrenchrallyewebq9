@extends('layout.master')
@section('title', 'Control Panel')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}" />
@stop
@section('content')
<h3><span class="glyphicon glyphicon-contacts"></span> Contacts</h3>
<hr>
<p>Rememer, if you click the button it should automatically start an email from your default email program. However, I think gmail limits the number of recipients from a 3rd party email program to a maximum of 100. So, if the group you are sending to has more than 100 people in it, you have to send the email through gmail's web interface (www.gmail.com). To get the list of emails to <b>copy and paste</b>, you just <b>right click</b> on the button and select <b>copy email address</b>. Then you can just paste it into the "to" section of the new email.</p>

@include('contacts.waitingList', $waitingList)

@include('contacts.membersByEvent', array($membersByEvent, $parentGroups, $membersByRallye))

@include('controlPanel.accessControl', $accessControl)


  
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