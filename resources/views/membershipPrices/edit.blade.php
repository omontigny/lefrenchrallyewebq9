@extends('layout.master')
@section('title', 'Edit a school')
@section('parentPageTitle', 'Admin')
@section('page-style')
@stop
@section('content')
<div class='container'>
  {{ Form::open(['method' => 'GET', 'url' => route('membershipprices.update', $membershipPrice->id) ]) }}
  @csrf

<div class="row">

  <div class="form-group form-float col-lg-3 col-md-6">
    <label for="schoolyear_id"><b>School Year</b></label>
    <select class="form-control show-tick ms select2" data-placeholder="Select"
        name="schoolyear_id" required>
        <option value="" selected disabled>-- Please select a school --</option>
        @foreach ($schoolyears as $schoolyear)
        <option value={{$schoolyear->id}} @if ($membershipPrice->schoolyear->id ===
            $schoolyear->id)
            selected
            @endif
            >{{$schoolyear->current_level}}/{{$schoolyear->next_level}}</option>
        @endforeach
    </select>
</div>

<div class="col-lg-6 col-md-6">
  <div class="form-check">
      <input class="form-check-input" type="checkbox" id="is_boarder" name="is_boarder"
          @if($membershipPrice->is_boarder)
      value="true" checked
      @else
      value="false"
      @endif
      >
      <label class="form-check-label" for="is_boarder"><b>For Boarder</b></label>
  </div>
</div>

 <div class="col-lg-3 col-md-4 col-12">
  <div class="form-group">
    <label for="mount"><b>Mount</b></label>
    {{form::text('mount', $membershipPrice->mount, ['class' => 'form-control', 'placeholder' => 'mount'])}}
  </div>
</div>

</div>


  {{Form::hidden('_method', 'PUT')}}
  {{form::submit('Submit', ['class' => 'btn btn-primary'])}}
  <a href="/membershipprices" class="btn btn-default float-right">Go back </a>
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