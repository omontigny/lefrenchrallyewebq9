@extends('layout.master')
@section('title', 'Calendars')
@section('parentPageTitle', 'Admin')
@section('page-style')
@stop
@section('content')


@if(count($datas) > 0)
<h3><span class="glyphicon glyphicon-bullhorn"></span> Calendars</h3>
<div class="table-responsive">
        <table class="table dataTable js-exportable">
            <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
              <thead class="thead-dark">
                <tr>
                  <th width="50vw;">Rallye</th>
                  <th width="30vw;">Group</th>
                  <th width="10vw;">Date event <font size="1">(DD-MM-YYYY)</font></th>
                </tr>
              </thead>
              <tbody>
              @foreach ($datas as $row)
                <tr>
                  <td><b>{{$row->title}} - {{$row->start_year . ' ' . $row->end_year}}</b></td>
                  <td><b>{{$row->name}}</b></td>
                  @if($row->eventDate != null)
                    <td><b>{{\Carbon\Carbon::parse($row->eventDate)->format('d-m-Y')}}</b></td>
                  @else
                    <td></td>
                  @endif
                </tr>
              @endforeach
              </tbody>
            </table>
            </div>
    @else
        <p> No calendar found </p>

    @endif
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
