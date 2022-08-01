@extends('layout.master')
@section('title', 'Invitations')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}" />
@stop
@section('content')
<h3><span class="glyphicon glyphicon-envelope"></span> Guest lists</h3>
<hr>

<!-- Exportable Table -->
@if(count($data) > 0)
<p>Since you are part of more than one event group, please select the event group you want to make the check IN on.</p>
<!--{{var_dump($data)}} -->
<div class="row clearfix">
  <div class="col-lg-12">
    <div class="card">
      <div class="header">
        <h2><strong>Guest</strong> List (Events)</h2>
      </div>
      <div class="body">
        <div class="table-responsive">
          <table class="table dataTable js-exportable">
            <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
            <thead class="thead-dark">
              <tr>
                <th>#</td>
                <th>Invitation</th>
                <th>Event Date (DD-MM-YYYY)</th>
                <th>Venue</th>
                <th>Theme</td>
                <th width="40px">Action</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $invitation)

              @if($invitation->group_id == $application->event_id)
              <tr>
                <td><strong>{{$invitation->id}}</strong></td>

                <td>
                    <div class="media-object"><img
                      src="{{$invitation->invitationFile}}"
                      alt="" width="35" class="rounded-circle"></div>
                </td>
                @if($invitation->group->eventDate != null )
                  <td><strong>{{\Illuminate\Support\Carbon::parse($invitation->group->eventDate)->format('d-m-Y')}}</strong></td>
                @else
                  <td></td>
                @endif
                <td>{{$invitation->venue_address}}</td>
                <td>{{$invitation->theme_dress_code}}</td>
                <td>
                  <a href="/guestsList/{{$invitation->id}}"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon  glyphicon-info-sign"></span></button></a>
                </td>
              </tr>
              @endif

              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@else
<p>E185: You do not have any invitation, no guest list to manage.</p>
@endif
<!-- #END# Exportable Table -->


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
