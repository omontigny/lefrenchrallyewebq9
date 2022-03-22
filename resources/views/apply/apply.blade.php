@extends('layout.master')
@section('title', 'Apply')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}"/>
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}"/>
@stop
@section('content')
<h3><span class="glyphicon glyphicon-file"></span> Applications</h3> 
<hr>
<p> Applications will be considered based on the following criteria:</p>
<ol> 
  <li>A balanced ratio of Boys and Girls.</li> 
  <li>A balanced ratio of children from French and English school systems.</li> 
  <li>Sibling policy: We give priority to children who have brothers/sisters that were or are currently part of Le French Rallye as long as the application is submitted before the deadline.</li>
  <li>We will prioritize applications by submission time. You will need to submit your application before the deadline for your Rallye (See below).</li> 
</ol>
<h3>Application Openings and Deadlines</h3>
<hr>
<!-- Exportable Table -->
@if(count($rallyes) > 0)
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Rallyes</strong> List</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                    <table class="table dataTable js-exportable">
                        <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                            <thead class="thead-dark">
                                <tr>
                                    <th>Title</th>
                                    <th width="40px;">Level</th>
                                    <th width="40px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                          @foreach ($rallyes as $rallye)
                            @if(!$rallye->status)
                                <tr class="table-danger">
                                    <td><strong>{{$rallye->title}}</strong></td>
                                    <td>{{$rallye->level}}</td>
                                      <td>Closed</td>
                                      </tr>
                                @else
                                  <tr class="table-success">
                                <td><strong>{{$rallye->title}}</strong></td>
                                <td>{{$rallye->level}}</td>
                                  <td>Opened</td>
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
  <p> No rallyes found </p>
        <a href={{secure_url("/rallyes/create")}}><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> Add new</button></a>
  @endif
    <!-- #END# Exportable Table --> 

<h3>My Applications</h3>
<hr>
<p>An application should be submitted for each of your children applying to Le French Rallye.</p>
@foreach ($rallyes as $rallye)
  @if ($rallye->status)
    <a href={{secure_url("/fullApplicationForm")}}><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> Start New Application</button></a>
    @break;
  @endif
@endforeach
<hr>
<!--'apply.myApplication', $applications)-->
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