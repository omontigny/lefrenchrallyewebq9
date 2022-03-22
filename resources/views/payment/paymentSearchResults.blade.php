@extends('layout.master')
@section('title', 'Rallye coordinators')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')
<div class="container-fluid">

    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>My child Payment</strong> process</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                    <table class="table ">
                        <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                            <thead class="thead-dark">
                                <tr>
                                    <th width="20px;">#</th>
                                    <th>Rallye</th>
                                    <th>child full name</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Amount</th>
                                    <th style="width:80px;" >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                          <tr>
                                    <td>{{$application->id}}</td>
                                    <td><strong>{{$application->rallye->title}}</strong></td>
                                    <td><strong>{{$application->childfirstname}} {{$application->childlastname}}</strong></td>

                                    @switch($application->status)
                                    @case(0)
                                    <td><span class="badge badge-info">Application</span></td>
                                    @break
                                    @case(4)
                                    <td><span class="badge badge-success">Approved</span></td>
                                    @break
                                    @case(2)
                                    <td><strong>Desactived</strong></td>
                                    @break
                                    @case(3)
                                    <td><span class="badge badge-warning">Waiting list</span></td>
                                    @break
                                    @case(1)
                                    <td><span class="badge badge-success">Membered</span></td>
                                    @break
                                    @case(5)
                                    <!--<td><strong>Ready</strong></td>-->
                                    @break
                                    @case(9)
                                    <td><span class="badge badge-danger">Blocked</span></td>
                                    <!--<td><strong>Rejected</strong></td>-->
                                    @break
                                    @endswitch
                                    @switch($application->status)
                                    @case(0)
                                    <td><span class="badge badge-info">Application</span></td>
                                    @break
                                    @case(4)
                                    <td><span class="badge badge-danger">TO DO</span></td>
                                    @break
                                    @case(2)
                                    <td><strong>Desactived</strong></td>
                                    @break
                                    @case(3)
                                    <td><span class="badge badge-warning">Waiting list</span></td>
                                    @break
                                    @case(1)
                                    <td><span class="badge badge-success">DONE</span></td>
                                    @break
                                    @case(5)
                                    <!--<td><strong>Ready</strong></td>-->
                                    @break
                                    @case(9)
                                    <td><span class="badge badge-danger">Blocked</span></td>
                                    <!--<td><strong>Rejected</strong></td>-->
                                    @break
                                    @endswitch
                                    <td><strong>{{$membershipPrice->mount}} (£)</strong></td>
                                    <td>
                                        {{-- <a href="/stripes/{{$application->id}}/edit"><button type="button" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit"></span> PAY</button></a> --}}
                                        <a href="/payments/{{$application->id}}/edit"><button type="button" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit"></span> PAY</button></a>
                                    </td>
                                </tr>
                          </tbody>
                        </table>
                        </div>
                </div>

            </div>
        </div>

    </div>
    <!-- #END# Exportable Table -->

</div>

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

