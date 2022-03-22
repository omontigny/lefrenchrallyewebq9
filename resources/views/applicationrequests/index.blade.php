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
@if($applications != null && count($applications) > 0)

<div class="container-fluid">
    <div class="row clearfix">
        <div class=""> <!-- Enlarge central pannel to have access to buttons but not centered (old value : col-lg-12 -->
            <div class="card">
                <div class="header">
                    <h2><b>Application requests</b> list</h2>
                </div>
                <div class="body">
                    <button type="button" class="btn  btn-simple btn-sm btn-default btn-filter"
                        data-target="all">All</button>
                    <button type="button" class="btn  btn-simple btn-sm btn-success btn-filter"
                        data-target="member">Member</button>
                    <button type="button" class="btn  btn-simple btn-sm btn-warning btn-filter"
                        data-target="suspended">Waiting list</button>
                    <button type="button" class="btn  btn-simple btn-sm btn-info btn-filter"
                        data-target="approved">Approved</button>
                    <button type="button" class="btn  btn-simple btn-sm btn-danger btn-filter"
                        data-target="application">Application</button>
                    <div class="table-responsive m-t-20">
                        <table class="table table-filter table-hover m-b-0">
                            <thead>
                                <th>ID</th>
                                <th>Child</th>
                                <th>Child name</th>
                                <th>Parent name</th>
                                <th>Rallye</th>
                                <th>School System</th>
                                <th>Boarder</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($applications as $application)
                                @switch($application->status)
                                @case(0)
                                <tr data-status="application">
                                    @break
                                    @case(1)
                                <tr data-status="member">
                                    @break
                                    @case(3)
                                <tr data-status="suspended">
                                    @break
                                    @case(4)
                                <tr data-status="approved">
                                    @break
                                    @endswitch

                                    <td>{{$application->id}}</td>

                                    <td>
                                        <div class="media-object"><img
                                                src="{{$application->childphotopath}}"
                                                alt="" height="45" width="45" class="rounded-circle"></div>
                                    </td>
                                    <td>{{$application->childfirstname}} {{$application->childlastname}}</td>
                                    <td>{{$application->parentfirstname}} {{$application->parentlastname}}</td>
                                    <td>{{$application->rallye->title}}</td>
                                    <td>{{$application->schoolstate}}</td>
                                    @if($application->is_boarder)
                                    <td><span class="badge badge-light">Boarder</span></td>
                                    @else
                                    <td>-</td>
                                    @endif

                                    @switch($application->status)
                                    @case(0)
                                    <td><span class="badge badge-danger">Application</span></td>
                                    @break
                                    @case(1)
                                    <td><span class="badge badge-success">Member</span></td>
                                    @break
                                    @case(2)
                                    <td><strong>Desactived</strong></td>
                                    @break
                                    @case(3)
                                    <td><span class="badge badge-warning">Waiting list</span></td>
                                    @break
                                    @case(4)
                                    <td><span class="badge badge-info">Approved</span>
                                    @if(count($payments) > 0 && $payments->firstWhere('application_id', $application->id) != null)
                                      <div class="badge badge-success">
                                        <span class="glyphicon glyphicon-gbp"></span>
                                      </div>
                                    @endif
                                    </td>
                                    @break
                                    @case(5)
                                    <!--<td><strong>Ready</strong></td>-->
                                    @break
                                    @case(9)
                                    <td><span class="badge badge-danger">Blocked</span></td>
                                    <!--<td><strong>Rejected</strong></td>-->
                                    @break
                                    @endswitch
                                    <td>
                                        <a href="/applicationrequests/{{$application->id}}"><button type="button"
                                            class="btn btn-info btn-sm"><span
                                                class="glyphicon glyphicon-edit"></span></button></a>

                                         @if($application->status != 9)
                                         <a href="/applicationrequests/{{$application->id}}/waiteApplicationById"><button
                                                type="button" class="btn btn-warning btn-sm"><span
                                                    class="glyphicon glyphicon-pause"></span></button></a>

                                          <a href="/applicationrequests/{{$application->id}}/blockingApplicationById"><button
                                                type="button" class="btn btn-danger btn-sm"><span
                                                    class="glyphicon glyphicon-ban-circle"></span></button></a>

                                        @else
                                          <a href="/applicationrequests/{{$application->id}}/deBlockingApplicationById"><button
                                              type="button" class="btn btn-success btn-sm"><span
                                                class="glyphicon glyphicon-ok-sign"></span></button></a>
                                        @endif

                                        <button type="button" class="btn btn-dark btn-sm  " data-toggle="modal" data-target="#DeletingApplication_{{$application->id}}"><span class="glyphicon glyphicon-remove"></span></button>

                                    </td>

                                             <!-- +AJO : Model section begin -->
                        <div class="modal fade" id="DeletingApplication_{{$application->id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content bg-danger">
                                    <div class="modal-header">
                                    <h4 class="title col-white text-center" id="defaultModalLabel">Delete Application</h4>
                                    </div>
                                    <div class="modal-body col-white">
                                        {{ Form::open(['method' => 'GET', 'url' => route('applicationrequests.destroy', $application->id)]) }}
                                    @csrf

                                    <p for=""><b>Child : </b>{{$application->childfirstname}} {{$application->childlastname}}</p>
                                    <p for=""><b>Parent: </b>{{$application->parentfirstname}} {{$application->parentlastname}}</p>
                                    <p for=""><b>Rallye: </b>{{$application->rallye->title}}</p>

                                    <div class="form-group">
                                        <label for="action"><b>Are you sure you want to delete this application ?</b></label>
                                    </div>
                                    </div>
                                    {{Form::hidden('_method', 'DELETE')}}
                                    <div class="modal-footer">
                                    <button type="submit" class="btn btn-link waves-effect col-white">Yes</button>
                                    <button type="button" class="btn btn-link waves-effect col-white" data-dismiss="modal">No,
                                        cancel</button>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                                </div>
                            </div>
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

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-blue"><i class="zmdi zmdi-male-alt"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">Boys</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="{{$boys}}" data-speed="2000"
                            data-fresh-interval="700">{{$boys}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-blush"><i class="zmdi zmdi-female"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">Girls</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="{{$girls}}" data-speed="2000"
                            data-fresh-interval="700">{{$girls}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-amber"><i class="zmdi zmdi-file-text"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">French</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="{{$frenchs}}" data-speed="2000"
                            data-fresh-interval="700">{{$frenchs}}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-parpl"><i class="zmdi zmdi-file-text"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">English</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="{{$englishs}}"
                            data-speed="{{2000}}" data-fresh-interval="700">{{$englishs}}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-amber"><i class="zmdi zmdi-group-work"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">App(Received)</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="{{$appReceived}}" data-speed="2000"
                            data-fresh-interval="700">{{$appReceived}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-blue"><i class="zmdi zmdi-group-work"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">App(Approved)</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="{{$appApproved}}" data-speed="2000"
                            data-fresh-interval="700">{{$appApproved}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-blush"><i class="zmdi zmdi-group-work"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">App(WaitingList)</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="{{$appWaitingList}}" data-speed="2000"
                            data-fresh-interval="700">{{$appWaitingList}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card product-report">
                <div class="body">
                    <div class="icon l-parpl"><i class="zmdi zmdi-group-work"></i></div>
                    <div class="col-in float-left">
                        <small class="text-muted">App(Member)</small>
                        <h4 class="m-t-0 number count-to" data-from="0" data-to="{{$appMembered}}"
                            data-speed="{{2000}}" data-fresh-interval="700">{{$appMembered}}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--
<div class="container-fluid">
    <h3>Quick access</h3>
    <a href={{secure_url("/acceptAllApplications")}}><button type="button" class="btn btn-primary">Accept
            all</button></a>
    <a href={{secure_url("/rejectAllApplications")}}><button type="button" class="btn btn-danger float-right">Reject
            all</button></a>

</div>
-->
@else
<p> No applications found </p>
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
