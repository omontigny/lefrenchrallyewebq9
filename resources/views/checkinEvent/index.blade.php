@extends('layout.master')
@section('title', 'Rallyes')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/sweetalert/sweetalert.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css')}}" />

{{-- <link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}" /> --}}
{{-- <link rel="stylesheet" href="{{secure_asset('assets/css/ecommerce.css')}}"> --}}
{{-- @include('components.head.tinymce-config') {{-- ## TinyMCE ##  --}}
@stop
@section('content')

@if(count($guestList) > 0)
<div class="container-fluid">
  <div class="row clearfix">
    <div class="col-lg-12">
      <div class="card">
        <div class="header">
          <h2><b>CHECK IN</b> list</h2>
        </div>
        <div class="body">
          <button type="button" class="btn  btn-simple btn-sm btn-default btn-filter" data-target="all">All</button>
          <button type="button" class="btn  btn-simple btn-sm btn-success btn-filter"
            data-target="Checked">Checked</button>
          <button type="button" class="btn  btn-simple btn-sm btn-info btn-filter"
            data-target="Expected">Expected</button>
          <button type="button" class="btn  btn-simple btn-sm btn-danger btn-filter"
            data-target="Absent">Absent</button>
          <!-- SMS   -->
          {{-- <a href="sms: {{$missingChildrenList ?? ''}}"><button type="button" class="btn btn-warning btn-sm float-right"><span
                class="glyphicon glyphicon-envelope"></span> SMS</button></a> --}}
          <!-- SMS -->
          <!-- MAIL MODAL -->
           {{-- <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#sendSMSModal"><span class="glyphicon glyphicon-send"></span> TWILIO</button> --}}
          <!-- MAIL -->

          <div class="table-responsive m-t-20">
            <table class="table table-filter table-hover m-b-0 js-exportable">
              <thead>
                <th>ID</th>
                <th>Action</th>
                <th>Child</th>
                <th>Child name</th>
                <th>Parent name</th>
                <th>Parent Phone number</th>
                <th>Status</th>
                <th>Present</th>
              </thead>
              <tbody>
                @foreach ($guestList as $row)
                @switch($row->child_present)
                @case(0)
                <tr data-status="Expected">
                  @break
                  @case(1)
                <tr data-status="Checked">
                  @break
                  @case(2)
                <tr data-status="Absent">
                  @break
                  @case(9)
                <tr data-status="blocked">
                  @break
                  @endswitch

                  <td>{{$row->id}}</td>
                  <td>
                    <a href="/multicheckin/edit/{{$row->id}}/{{$invitation_id}}">
                      <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-success btn-sm glyphicon glyphicon-ok"></button>
                        <button type="button" class="btn btn-danger btn-sm glyphicon glyphicon-remove"></button>
                      </div>
                    </a>
                  {{-- <button type="button" class="btn btn-danger btn-sm"><span
                          class="glyphicon glyphicon-ok"></span> <span
                          class="glyphicon glyphicon-remove"></span></button> --}}
                  </td>
                  <td>
                    <div class="media-object"><img src="{{$row->childphotopath}}" alt="" width="35"
                        class="rounded-circle"></div>
                  </td>
                  <td>{{$row->childfirstname}} {{$row->childlastname}}</td>
                  <td>{{$row->parentfirstname}} {{$row->parentlastname}}</td>
                  <td><strong><a href="sms:{{$row->parentmobile}}">{{$row->parentmobile}}</a></strong></td>

                  @switch($row->checkStatus)
                  @case(0)
                  <td><span class="badge badge-info">Expected</span></td>
                  @break
                  @case(1)
                  <td><span class="badge badge-success">Attending</span></td>
                  @break
                  @case(2)
                  <td><span class="badge badge-danger">Absent</span></td>
                  @break
                  @case(3)
                  <td><span class="badge badge-warning">Waiting list</span></td>
                  @break
                  @endswitch

                  @switch($row->child_present)
                  @case(0)
                  <td><span class="badge badge-info">Expected</span></td>
                  @break
                  @case(1)
                  <td><span class="badge badge-success">Present</span></td>
                  @break
                  @case(2)
                  <td><span class="badge badge-danger">Absent</span></td>
                  @break
                  @case(3)
                  <td><span class="badge badge-warning">Waiting list</span></td>
                  @break
                  @endswitch

                  <!-- Modal Cancel Checkin -->
                  {{-- @include('checkinEvent.partials.cancelCheckinModal') --}}
                  <!-- END MODAL-->

                  <!--  Modal Confirm Checkin -->
                  {{-- @include('checkinEvent.partials.confirmCheckinModal') --}}
                  <!-- END MODAL-->

                  <!--  Modal Send SMS -->
                  {{-- @include('checkinEvent.partials.sendSMSModal') --}}
                  <!-- END MODAL-->


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

@else
<p>E184: No Checkin found </p>
@endif
<br />

@stop
@section('page-script')
{{-- <script src="{{secure_asset('assets/bundles/morrisscripts.bundle.js')}}"></script> --}}
<script src="{{secure_asset('assets/bundles/jvectormap.bundle.js')}}"></script>
<script src="{{secure_asset('assets/bundles/flotscripts.bundle.js')}}"></script>
<script src="{{secure_asset('assets/bundles/sparkline.bundle.js')}}"></script>
<script src="{{secure_asset('assets/bundles/knob.bundle.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/ecommerce.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/charts/jquery-knob.min.js')}}"></script>

<script src="{{secure_asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/ui/dialogs.js')}}"></script>


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
<script>
  $(document).ready(function () {
        $('.star').on('click', function () {
            $(this).toggleClass('star-checked');
        });

        $('.ckbox label').on('click', function () {
            $(this).parents('tr').toggleClass('selected');
        });

        $('.btn-filter').on('click', function () {
            var $target = $(this).data('target');
            if ($target != 'all') {
                $('.table tr').css('display', 'none');
                $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
            } else {
                $('.table tr').css('display', 'none').fadeIn('slow');
            }
        });
    });
</script>
@stop
