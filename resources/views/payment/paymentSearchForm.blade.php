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
@stop
@section('content')
<div class='container'>
  <h2>Child payment info.</h2>
{{ Form::open(['method' => 'GET', 'url' => route('paymentsearch.find')]) }}
@csrf
  <fieldset>
      <div class="form-group form-float">
        <label for="childfirstname"><b>Your child firstname</b></label>
        {{form::text('childfirstname', '', ['class' => 'form-control', 'placeholder' => 'Child firstname'])}}
        <div class="help-info">
        <p>Please enter the first name of your child for whom you want to make the payment</p>
      </div>
    </div>

    <fieldset>
      <div class="form-group form-float">
        <label for="childlastname"><b>Your child lastname</b></label>
        {{form::text('childlastname', '', ['class' => 'form-control', 'placeholder' => 'Child lastname'])}}
        <div class="help-info">
          <p>Please enter the last name of your child for whom you want to make the payment</p>
      </div>
    </div>

    <fieldset>
      <div class="form-group form-float">
        <label for="parentemail"><b>Your email address</b></label>
        {{form::text('parentemail', '', ['class' => 'form-control', 'placeholder' => 'Parent email'])}}
        <div class="help-info">
          <p>Please enter your email address you did in your application request</p>
      </div>
    </div>

  {{form::submit('Search', ['class' => 'btn btn-primary'])}}
{{ Form::close() }}
</div>
@stop
@section('page-script')
<script src="{{secure_asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{secure_asset('assets/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-spinner/js/jquery.spinner.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
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
