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
@if(count($applications) > 0)

<div class="container-fluid">
    <div class="row clearfix">
        <div class=""><!-- old value col-lg-12 -->
            <div class="card">
                <div class="header">
                    <h2><b>Parent event groups</b> list</h2>
                </div>
                <div class="body">
                    <button type="button" class="btn  btn-simple btn-sm btn-default btn-filter"
                        data-target="all">All</button>
                    <button type="button" class="btn  btn-simple btn-sm btn-success btn-filter"
                        data-target="Assigned">ASSIGNED</button>
                    <!--<button type="button" class="btn  btn-simple btn-sm btn-warning btn-filter"
                        data-target="suspended">Waiting list</button>-->
                    <button type="button" class="btn  btn-simple btn-sm btn-info btn-filter"
                        data-target="Non assigned">NON ASSIGNED</button>
                    <!--<button type="button" class="btn  btn-simple btn-sm btn-danger btn-filter"
                        data-target="blocked">Blocked</button>-->
                    <div class="table-responsive m-t-20">

                        <table class="table table-filter table-hover m-b-0">

                            <thead>
                                <th>Child</th>
                                <th>Child name</th>
                                <th>Parent name</th>
                                <th>Boarder</th>
                                <th>Rallye</th>
                                <th>Group</th>
                                <th>Event Date <br><font size="1">(DD-MM-YYYY)</font></th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($applications as $application)
                                @switch($application->evented)
                                @case(0)
                                <tr data-status="Non assigned">
                                    @break
                                    @case(1)
                                <tr data-status="Assigned">
                                    @break
                                    @case(3)
                                <tr data-status="suspended">
                                    @break
                                    @case(9)
                                <tr data-status="blocked">
                                    @break
                                    @endswitch

                                    <td>
                                        <div class="media-object"><img src="{{$application->childphotopath}}" alt=""
                                                width="35" class="rounded-circle"></div>
                                    </td>
                                    <td>{{$application->childfirstname}} {{$application->childlastname}}</td>
                                    <td>{{$application->parentfirstname}} {{$application->parentlastname}}</td>
                                    @if($application->is_boarder)
                                    <td><span class="badge badge-light">Boarder</span></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td>{{$application->rallye->title}}</td>
                                    <td>
                                        @if($application->rallye->isPetitRallye && $application->group_name != '')
                                        {{$application->group_name}}
                                        @else
                                        -
                                        @endif

                                    </td>
                                    <td>
                                        @if($application->event != null)
                                          {{\Illuminate\Support\Carbon::parse($application->event->eventDate)->format('d-m-Y')}}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    @switch($application->evented)
                                    @case(0)
                                    <td><span class="badge badge-info">NON ASSIGNED</span></td>
                                    @break
                                    @case(1)
                                    <td><span class="badge badge-success">ASSIGNED</span></td>
                                    @break
                                    @case(2)
                                    <td><strong>Desactived</strong></td>
                                    @break
                                    @case(3)
                                    <td><span class="badge badge-warning">Waiting list</span></td>
                                    @break
                                    @case(4)
                                    <!--<td><strong>Engaged</strong></td>-->
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
                                        @if(Auth::user()->active_profile == Config::get('constants.roles.COORDINATOR')
                                        ||
                                        Auth::user()->active_profile == Config::get('constants.roles.SUPERADMIN'))
                                        @if($application->rallye->isPetitRallye)
                                        <a
                                            href="/ParentGroupsController/{{$application->id}}/showGroupMembersSameApplicationGroupName"><button
                                                type="button" class="btn btn-warning btn-sm"><span
                                                    class="glyphicon glyphicon-info-sign"></span></button></a>
                                        @endif
                                        @if($application->event_id != null)
                                        <a
                                            href="/ParentGroupsController/{{$application->event_id}}/showGroupMembersSameApplicationEvent"><button
                                                type="button" class="btn btn-dark btn-sm"><span
                                                    class="glyphicon glyphicon-menu-hamburger"></span></button></a>
                                        @endif
                                                    @endif


                                        <button type="button" class="btn btn-primary btn-sm  " data-toggle="modal"
                                            data-target="#AffectingParentEventModal_{{$application->id}}"><span
                                                class="glyphicon glyphicon-check"></span></button>
                                    </td>

                                    <!-- +AJO : Model section begin -->
                                    <div class="modal fade" id="AffectingParentEventModal_{{$application->id}}"
                                        tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="title text-center" id="defaultModalLabel">Parent Event By
                                                        Child
                                                    </h4>
                                                </div>

                                                <div class="modal-body">
                                                    {{ Form::open(['action' => 'ParentEventsController@store', 'method' => 'GET']) }}
                                                    @csrf
                                                    <p for=""><b>Child : </b>{{$application->childfirstname}}
                                                        {{$application->childlastname}}</p>
                                                    <p for=""><b>Parent: </b>{{$application->parentfirstname}}
                                                        {{$application->parentlastname}}</p>
                                                    <p for=""><b>Rallye: </b>{{$application->rallye->title}}</p>
                                                    @if($application->group_name != '')
                                                    <p for=""><b>Group: </b>{{$application->group_name}}</p>
                                                    @endif


                                                    <div class="form-group form-float">
                                                        <label for="group_id"><b>Event date</b></label>
                                                        <select class="form-control show-tick ms select2"
                                                            data-placeholder="Select" name="group_id" required>
                                                            <option value="" selected disabled>-- Please select a
                                                                rallye's group
                                                                --</option>
                                                            @if($application->evented)
                                                            <option value="0" class="col-red">Make parent and his/her
                                                                child in
                                                                the selected event group</option>
                                                            @endif
                                                            @if($application->rallye->isPetitRallye)
                                                            <!-- Managing event for PetitRallye -->
                                                            @foreach ($groups as $group)
                                                            @if($group->rallye_id == $application->rallye->id)
                                                            @if($application->group_name == $group->name
                                                            && $application->event_id == $group->id)
                                                            <option value={{$group->id}} selected>{{\Illuminate\Support\Carbon::parse($group->eventDate)->format('d-m-Y')}}
                                                                ({{$group->parentsInEvents}})
                                                            </option>
                                                            @elseif($application->group_name == $group->name)
                                                            <option value={{$group->id}}>{{\Illuminate\Support\Carbon::parse($group->eventDate)->format('d-m-Y')}}
                                                                ({{$group->parentsInEvents}})
                                                            </option>
                                                            @endif
                                                            @endif
                                                            @endforeach
                                                            @elseif(!$application->rallye->isPetitRallye)
                                                            <!-- Managing event for PetitRallye -->
                                                            @foreach ($groups as $group)
                                                            @if($group->rallye_id == $application->rallye->id)
                                                            @if($application->event_id == $group->id)
                                                            <option value={{$group->id}} selected>{{\Illuminate\Support\Carbon::parse($group->eventDate)->format('d-m-Y')}}
                                                                ({{$group->parentsInEvents}})
                                                            </option>
                                                            @elseif($application->rallye_id == $group->rallye_id)
                                                            <option value={{$group->id}}>{{\Illuminate\Support\Carbon::parse($group->eventDate)->format('d-m-Y')}}
                                                                ({{$group->parentsInEvents}})
                                                            </option>
                                                            @endif
                                                            @endif
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        <!-- Managing event for standardRallye -->
                                                    </div>

                                                    <input name="application_id" type="hidden"
                                                        value="{{$application->id}}">
                                                    <div class="modal-footer">
                                                        @if($application->evented != 0)
                                                        {{form::submit('Update', ['class' => 'btn btn-primary'])}}
                                                        @else
                                                        {{form::submit('Add new', ['class' => 'btn btn-primary'])}}
                                                        @endif


                                                        <button type="button" class="btn btn-default float-right"
                                                            data-dismiss="modal">Cancel</button>
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
