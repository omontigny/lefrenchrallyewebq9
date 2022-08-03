@extends('layout.master')
@section('title', 'Checkins')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/sweetalert/sweetalert.css')}}" />
<style type="text/css">
  p.petit {
    zoom: 75%;
  }
</style>
@stop
@section('content')
@if(count($checkins) > 0)
  <div class="btn-group-vertical float-right" role="group" aria-label="...">
      <!-- BACK -->
      <a href="{{ URL::previous() }}" class="btn btn-default btn-sm btn-default">Back</a>
      <!-- BACK -->
  </div>
  <div class="container-fluid">

    <!-- Exportable Table -->
    <div class="row clearfix">
      <div class="col-lg-12">
        <div class="card">
          <div class="header">
            <h2><strong>My invitations</strong> List</h2>
          </div>
          <div class="body">
            <div class="table-responsive">
              <table class="table dataTable js-exportable">
                <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                <thead class="thead-dark">
                  <tr>
                    <th>
                      <p class="petit">Child f-name</p>
                    </th>
                    <th>
                      <p class="petit">Child l-name</p>
                    </th>
                    <th>
                      <p class="petit">Event date (DD-MM-YYYY)</p>
                    </th>
                    <th>
                      <p class="petit">Venue</p>
                    </th>
                    <th>
                      <p class="petit">Theme/Dress Code</p>
                    </th>
                    <th>
                      <p class="petit">Start time</p>
                    </th>
                    <th>
                      <p class="petit">End time</p>
                    </th>
                    <th>
                      <p class="petit">Status</p>
                    </th>

                    <th style="width:80px;">
                      <p class="petit">Action
                    </th>

                  </tr>
                </thead>
                <tbody>
                  @foreach ($checkins as $checkin)
                      @switch($checkin->checkStatus)
                      @case(0)
                      <tr>
                          @break
                          @case(1)
                          <tr class="table-success">
                              @break
                          @case(2)
                          <tr class="table-danger">
                              @break
                          @default

                      @endswitch
                      <td>
                        <p class="petit">{{$checkin->childfirstname}}</p>
                      </td>
                      <td>
                        <p class="petit">{{$checkin->childlastname}}</p>
                      </td>
                      @if($checkin->eventDate != null)
                        <td>
                          <p class="petit">{{\Illuminate\Support\Carbon::parse($checkin->eventDate)->format('d-m-Y')}}</p>
                        </td>
                      @else
                        <td></td>
                      @endif
                      <td>
                        <p class="petit">{{$checkin->venue_address}}</p>
                      </td>
                      <td>
                        <p class="petit">{{$checkin->theme_dress_code}}</p>
                      </td>
                      <td>
                        <p class="petit">{{$checkin->start_time}}</p>
                      </td>
                      <td>
                        <p class="petit">{{$checkin->end_time}}</p>
                      </td>
                      <td>
                        @if($checkin->checkStatus == 1)
                          <p class="petit">Attending</p>
                        @elseif($checkin->checkStatus == 2)
                          <p class="petit">Non attending</p>
                        @else
                          <p class="petit">No response</p>
                        @endif
                      </td>
                      <td>
                        <button type="button" class="btn btn-primary btn-sm  " data-toggle="modal"
                          data-target="#ConfirmCheckInModal_{{$checkin->id}}"><span class="glyphicon glyphicon-check"></span></button>
                          <button type="button" class="btn btn-danger btn-sm  " data-toggle="modal"
                        data-target="#CancelingCheckInModal_{{$checkin->id}}"><span class="glyphicon glyphicon-remove"></span></button>
                      </td>
                  </tr>
                  <!-- +AJO : Model section begin -->
                  <div class="modal fade" id="CancelingCheckInModal_{{$checkin->id}}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content bg-danger">
                        <div class="modal-header">
                          <h4 class="title col-white text-center" id="defaultModalLabel">Invitation decline</h4>
                        </div>
                        <div class="modal-body col-white">
                              {{ Form::open(['action' => ['CheckinController@update', $checkin->id], 'method' => 'POST']) }}
                          @csrf
                          <div class="form-group">
                            <label for="action"><b>Are you sure your child will NOT be attending ?</b></label>
                            <input name="action" type="hidden" value="0">
                          </div>
                        </div>
                        {{Form::hidden('_method', 'PUT')}}
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

                    <!-- +AJO : Model section begin -->
                    <div class="modal fade" id="ConfirmCheckInModal_{{$checkin->id}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content bg-green">
                            <div class="modal-header">
                              <h4 class="title col-white text-center" id="defaultModalLabel">Invitation - Confirmation</h4>
                            </div>
                            <div class="modal-body col-white">
                                {{ Form::open(['action' => ['CheckinController@update', $checkin->id], 'method' => 'POST']) }}
                              @csrf
                              {{Form::hidden('_method', 'PUT')}}
                              <div class="form-group">
                                <label for="action"><b>Do you really want to confirm your invitation?</b></label>
                                <input name="action" type="hidden" value="1">
                              </div>
                            </div>
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
<p>ChekinKids: No invitations found </p>
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
