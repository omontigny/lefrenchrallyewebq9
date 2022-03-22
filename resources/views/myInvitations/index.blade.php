@extends('layout.master')
@section('title', 'Rallyes')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/sweetalert/sweetalert.css')}}" />

<link rel="stylesheet" href="{{secure_asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/css/ecommerce.css')}}">
@stop
@section('content')
@if(count($data) > 0)

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><b>My kids Invitations</b> list</h2>
                    <p style="color:#FF0000">You will find below the invitations of your children from all rallyes</p>
                </div>
                <div class="body">
                    <button type="button" class="btn  btn-simple btn-sm btn-default btn-filter"
                        data-target="all">All</button>
                    <button type="button" class="btn  btn-simple btn-sm btn-success btn-filter"
                        data-target="Attending">Attending</button>
                    <button type="button" class="btn  btn-simple btn-sm btn-info btn-filter"
                        data-target="Not replied">Not replied</button>
                    <button type="button" class="btn  btn-simple btn-sm btn-danger btn-filter"
                        data-target="Not attending">Not attending</button>

                    <div class="table-responsive m-t-20">
                        <table class="table table-filter table-hover m-b-0">
                            <thead>
                                <th>ID</th>
                                <th>Action</th>
                                <th>Child</th>
                                <th>Child name</th>
                                <th>theme dress code</th>
                                <th>Event Date <font size="1">(DD-MM-YYYY)</font></th>
                                <th>Starts at</th>
                                <th>Ends at</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                @switch($row->checkStatus)
                                @case(0)
                                <tr data-status=">Not replied">
                                    @break
                                    @case(1)
                                <tr data-status="Attending">
                                    @break
                                    @case(2)
                                <tr data-status="Not attending">
                                    @break
                                    @case(9)
                                <tr data-status="blocked">
                                    @break
                                    @endswitch

                                    <td>{{$row->id}}</td>
                                    <td>
                                      <a  href="myinvitations/attending/{{$row->id}}"><button type="button" class="btn btn-primary btn-sm"><span
                                          class="glyphicon glyphicon-check"></span></button></a>

                                      <a  href="myinvitations/notattending/{{$row->id}}"><button type="button" class="btn btn-danger btn-sm"><span
                                          class="glyphicon glyphicon-remove"></span></button></a>
                                    </td>
                                    <td>
                                      <div class="media-object"><img
                                              src="{{$row->childphotopath}}"
                                              alt="" width="35" class="rounded-circle">
                                      </div>
                                    </td>
                                    <td>{{$row->childfirstname}}</td>
                                    <td>{{$row->theme_dress_code}}</td>
                                    @if($row->eventDate != null)
                                      <td>{{\Carbon\Carbon::parse($row->eventDate)->format('d-m-Y')}}</td>
                                    @else
                                      <td></td>
                                    @endif
                                    <td>{{$row->start_time}}</td>
                                    <td>{{$row->end_time}}</td>

                                    @switch($row->checkStatus)
                                    @case(0)
                                    <td><span class="badge badge-info">Not replied</span></td>
                                    @break
                                    @case(1)
                                    <td><span class="badge badge-success">Attending</span></td>
                                    @break
                                    @case(2)
                                    <td><span class="badge badge-danger">Not Attending</span></td>
                                    @break
                                    @endswitch
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
<p>E188: No Invitation found </p>
@endif
<br />

@stop
@section('page-script')
<script src="{{secure_asset('assets/bundles/morrisscripts.bundle.js')}}"></script>
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
