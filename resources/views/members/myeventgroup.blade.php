@extends('layout.master')
@section('title', 'Rallyes')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')

@if(count($applications) > 0)
<div class="btn-group-vertical float-right" role="group" aria-label="...">
  @if(Auth::user()->active_profile == Config::get('constants.roles.COORDINATOR') || Auth::user()->active_profile == Config::get('constants.roles.SUPERADMIN'))
    <!-- MAIL -->
    <a href="mailto:?bcc={{$bcclist}}"><button type="button" class="btn btn-warning btn-sm float-right"><span class="glyphicon glyphicon-envelope"></span> Mail</button></a>
    <!-- MAIL -->
  @endif
  <!-- BACK -->
  <a href="{{ URL::previous() }}" class="btn btn-default btn-sm btn-default">Back</a>
  <!-- BACK -->
</div>

<div class="container-fluid">

    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div>
            <div class="card">
                <div class="header">
                    <h2><strong>My Event group</strong> List</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                      <table class="table dataTable js-exportable
                      {{-- @if(Auth::user()->active_profile == Config::get('constants.roles.COORDINATOR') || Auth::user()->active_profile == Config::get('constants.roles.SUPERADMIN'))
                      js-exportable
                      @endif --}}
                      ">
                        <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                            <thead class="thead-dark">
                                <tr>
                                    <th>Child</th>
                                    <th>Rallyes</th>
                                    <th>Group</th>
                                    <th>Date event<font size="1">(DD-MM-YYYY)</font></th>
                                    <th>Parent</th>
                                    <th>Email</th>
                                    <th>Home phone</th>
                                    <th>mobile</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($applications as $application)
                                <tr>
                                    <td><b>{{$application->childfirstname . ' ' . $application->childlastname}}</b></td>
                                    <td><b>{{$application->rallye->title}}</b></td>
                                    @if($application->grouped)
                                    <td><b>{{$application->group->name}}</b></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if($application->evented == 1)
                                    <td><b>{{\Carbon\Carbon::parse($application->event->eventDate)->format('d-m-Y')}}</b></td>
                                  @else
                                    <td>-</td>
                                  @endif
                                    <td><b>{{$application->parentfirstname . ' ' . $application->parentlastname}}</b></td>
                                    <td><b><a href="mailto:{{$application->parentemail}}">{{$application->parentemail}}</a></b></td>
                                    <td><b><a href="tel:{{$application->parenthomephone}}">{{$application->parenthomephone}}</a></b></td>
                                    <td><b><a href="sms:{{$application->parentmobile}}">{{$application->parentmobile}}</a></b></td>
                                </tr>
                              @endforeach
                          </tbody>
                        </table>
                        </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    <!-- #END# Exportable Table --> -

</div>

  @else
        <p>E181: Your group is not defined yet! Please try later on!</p>
    @endif
    <br />


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

