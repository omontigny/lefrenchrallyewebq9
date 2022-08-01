@extends('layout.master')
@section('title', 'Rallyes')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')

@if(count($applications) > 0)
  <div class="container-fluid">

    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>My Applications</strong> List</h2>
                    <div class="help-info text-danger">
                      <p><strong>Please choose for which child you want to see the event group or manage the invitation as member of the associated event group.</strong></p>
                      <p>Use action buttons to : </p>
                       <ul>
                         <li>see child event group members</li>
                         <li>confirm your child attending state </li>
                         <li>send an invitation about the current event date </li>
                         <li>check your guest list</li>
                       </ul>
                    </div>

                </div>
                <div class="body">
                    <div class="table-responsive">
                    <table class="table dataTable js-exportable">
                        <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                            <thead class="thead-dark">
                                <tr>
                                    <th width="20px;">#</th>
                                    <th>Child name</th>
                                    <th>Rallye</th>
                                    <th>Group</th>
                                    <th>Event Date (DD-MM-YYYY)</th>
                                    <th style="width:60px;" >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                          @foreach ($applications as $application)
                                  <tr>
                                  <td>{{$application->id}}</td>
                                    <td><strong>{{$application->childfirstname}} {{$application->childlastname}}</strong></td>
                                    <td><strong>{{$application->rallye->title}}</strong></td>
                                    <td><strong>{{$application->group_name}}</strong></td>
                                    @if($application->event != null)
                                      <td><strong>{{\Illuminate\Support\Carbon::parse($application->event->eventDate)->format('d-m-Y')}}</strong></td>
                                    @else
                                      <td><strong>-</strong></td>
                                    @endif
                                    <td>
                                        <a href="/parentChildren/{{$application->id}}"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon  glyphicon-info-sign"></span></button></a>
                                        @if($application->event != null)
                                        <a href="/checkinkids/{{$application->id}}"><button type="button" class="btn btn-dark btn-sm"><span class="glyphicon  glyphicon-random"></span></button></a>
                                        <a href="invitations/{{$application->id}}"><button type="button" class="btn btn-danger btn-sm"><span class="glyphicon  glyphicon-send"></span></button></a>
                                        <a href="/checkin/{{$application->id}}/checkIn"><button type="button" class="btn btn-warning btn-sm"><span class="glyphicon  glyphicon-check"></span></button></a>
                                        @endif
                                    </td>
                                </tr>
                        @endforeach
                          </tbody>
                        </table>
                        </div>
                </div>
            </div>
        </div>

    </div>
    <!-- #END# Exportable Table -->

</div>

  @else
        <p> No applications found </p>
    @endif

@stop
@section('page-script')
<!-- To manage dialog box -->
<script src="{{secure_asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/ui/dialogs.js')}}"></script>
<!-- End: To manage dialog box -->

<script src="{{secure_asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
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

