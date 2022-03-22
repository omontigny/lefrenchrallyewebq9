@extends('layout.master')
@section('title', 'Checkin Presence')
@section('parentPageTitle', 'Admin')
@section('page-style')
@stop
@section('content')
<div class="container-fluid profile-page">
  <div class="row clearfix">
    <div class="col-lg-12 col-md-12">
      <div class="card profile-header bg-dark">
        <div class="body col-white">
          <div class="row">
            <div class="col-lg-3 col-md-4 col-12">
              <div class="profile-image float-md-right"><img src="{{$application->childphotopath}}" alt="" width="35"
                  class="rounded-circle">
              </div>
            </div>
            <div class="col-lg-9 col-md-8 col-12">
              <h4 class="m-t-0 m-b-0"><strong>{{$application->childlastname}}</strong>
                {{$application->childfirstname}}</h4>
              <span class="job_post">{{$application->rallye->title}}</span>

              @if($application->is_boarder)
              <span class="badge badge-dark">Boarder</span>
              @endif
              @switch($application->status)
              @case(0)
              <span class="badge badge-danger">Application</span>
              @break
              @case(1)
              <span class="badge badge-success">Member</span>
              @break
              @case(2)
              @break
              @case(3)
              <span class="badge badge-warning">Waiting list</span>
              @break
              @case(4)
              <span class="badge badge-info">Aproved</span>
              @break
              @case(5)
              <!--<td><strong>Ready</strong></td>-->
              @break
              @case(9)
              <span class="badge badge-danger">Rejected</span>
              @break
              @endswitch
              <div>
                {{ Form::open(['action' => 'ApplicationRequestsPrivateController@updateChildPicture', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                @csrf
                <input type="hidden" id="applicationID" name="applicationID" value="{{$application->id}}">
                <div class="col-lg-3 col-md-6"> <b>Child picture</b>
                  <div class="input-group">
                      <input name="childphotopath" value="{{$application->childphotopath}}" id="file" type="file" onchange="Filevalidation()" multiple required /><span id="size"></span>
                  </div>
              </div>
                {{form::submit('Submit', ['class' => 'btn btn-primary'])}}
                <a href="/applicationrequests/{{$application->id}}" class="btn btn-default float-right">Go back </a>
                {{ Form::close() }}
                <br />
                </a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
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
