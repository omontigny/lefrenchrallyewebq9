@extends('layout.master')
@section('title', 'Invitations')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}" />
@stop
@section('content')
<h3><span class="glyphicon glyphicon-envelope"></span> Invitations - Other Events</h3>
<hr>
<p>Below you will find all the events in your Rallye and you can see whether they have selected a venue and theme. This
  is in order to prevent two events having the same venue or theme. <span class="bg-success text-white">Your event is
    highlighted in green</span>. Scroll down to set your event venue and theme in the next section.</p>

<!-- Exportable Table -->
@if(count($invitations) > 0)
<!--{{var_dump($invitations)}} -->
<div class="row clearfix">
  <div class=""> <!-- Enlarge central pannel to have access to buttons but not centered (old value : col-lg-12 -->
    <div class="card">
      <div class="header">
        <h2><strong>Invitations</strong> List</h2>
      </div>
      <div class="body">
        <div class="table-responsive">
          <table class="table dataTable js-exportable">
            <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
            <thead class="thead-dark">
              <tr>
                <th>#</td>
                <th>Invitation</th>
                <th>Event Date (DD-MM-YYYY)</th>
                <th>Venue</th>
                <th>Theme</td>
                <th>Owner</td>
                <th>Status</td>
                <th>Actions</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($oldInvitations as $invitation)

              <tr class="bg-light text-muted">
                <td><strong>{{$invitation->id}}</strong></td>
                <td>
                    <div class="media-object"><img
                      src="{{$invitation->invitationFile}}"
                      alt="" width="35" class="rounded-circle"></div>
                </td>
                @if($invitation->group != null)
                  <td>{{\Illuminate\Support\Carbon::parse($invitation->group->eventDate)->format('d-m-Y')}}</td>
                @else
                  <td>-</td>
                @endif
                <td>{{$invitation->venue_address}}</td>
                <td>{{$invitation->theme_dress_code}}</td>
                <td>{{$invitation->user->name}}</td>
                <td class="text-warning">Finished</td>
                <td> - </td>
              </tr>

              @endforeach
              @foreach ($invitations as $invitation)

              @if($invitation->group_id == $application->event_id)

              <tr class="bg-success text-white">
                @else
              <tr>
                @endif
                <td><strong>{{$invitation->id}}</strong></td>

                <td>
                  <div class="media-object">
                    <img src="{{$invitation->invitationFile}}" alt="" width="35" class="rounded-circle">
                  </div>
                </td>
                @if($invitation->group != null)
                  <td>{{\Illuminate\Support\Carbon::parse($invitation->group->eventDate)->format('d-m-Y')}}</td>
                @else
                  <td>-</td>
                @endif
                <td>{{$invitation->venue_address}}</td>
                <td>{{$invitation->theme_dress_code}}</td>
                <td>{{$invitation->user->name}}</td>
                <td>Incoming</td>
                <td>
                  <a href={{secure_url("/sendToMyself/".$invitation->id)}}>
                    <button type="button" class="btn btn-warning btn-md"><span class="glyphicon glyphicon-envelope"></span> Mail to myself</button>
                  </a>
                  <button type="button" class="btn btn-danger btn-sm  " data-toggle="modal" data-target="#DeletingInvitation_{{$invitation->id}}"><span class="glyphicon glyphicon-remove"></span></button>
                </td>

                <!-- +AJO : Model section begin -->
                <div class="modal fade" id="DeletingInvitation_{{$invitation->id}}" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                  <div class="modal-content bg-danger">
                      <div class="modal-header">
                      <h4 class="title col-white text-center" id="defaultModalLabel">Delete Invitation</h4>
                      </div>
                      <div class="modal-body col-white">
                          {{ Form::open(['method' => 'GET', 'url' => route('invitations.destroy', $invitation->id)]) }}
                      @csrf

                      <p for=""><b>Event Date : </b>{{\Illuminate\Support\Carbon::parse($invitation->group->eventDate)->format('d-m-Y')}}</p>
                      <p for=""><b>Theme: </b>{{$invitation->theme_dress_code}}</p>
                      <p for=""><b>Rallye: </b>{{$invitation->rallye->title}}</p>

                      <div class="form-group">
                          <label for="action"><b>Are you sure you want to delete this invitation ?</b></label>
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
@endif
<!-- #END# Exportable Table -->

<h3>Invitation</h3>
<p>Below, you can enter the information about your event and then upload and send an invitation to all members of your
  Rallye.<br />
  <span class="text-danger"><strong>Note: You can not change this information after sending out the RSVP's. So be
    careful!</strong></span></p>
<div class='container'>
  {{ Form::open(['action' => 'InvitationsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
  @csrf
  <div class="form-group form-float">
    <label for="calendar_id"><b>Event date</b></label>
     <select class="form-control show-tick ms select2" data-placeholder="Select" name="calendar_id" required>
      <option value="" selected disabled>-- Please select a group - event date --</option>
      @foreach ($groups as $group)
        @foreach($groupsID as $groupID)
            @if($group->id == $groupID)
              <option value={{$group->id}}>{{$group->rallye->title . ' ' . $group->name . ' ' . \Illuminate\Support\Carbon::parse($group->eventDate)->format('d-m-Y')}}</option>
            @endif
      @endforeach
      @endforeach
    </select>
  </div>

  <div class="form-group form-float">
    <label for="venue_address"><b>Venue Address</b></label>
    {{form::text('venue_address', '', ['class' => 'form-control', 'placeholder' => 'Venue Address'])}}
  </div>

  <div class="form-group form-float ">
    <label for="theme_dress_code"><b>Theme/Dress Code</b></label>
    <input type="text" name="theme_dress_code" placeholder="Theme/Dress Code"
           pattern="^[ A-Za-z0-9_.-]*$" class="form-control">
    <div class="help-info">
      <p>Avoid some special caracters like (&\/$€`()[]@#+%?!~). You can use (-_.)</p>
    </div>
  </div>

  {{-- <div class="form-group form-float">
    <label for="theme_dress_code"><b>Theme/Dress Code</b></label>
    {{form::text('theme_dress_code', '', ['class' => 'form-control', 'placeholder' => 'Theme/Dress Code'])}}
  </div> --}}

  <div class="form-group form-float">
    <label for="start_time"><b>Start time</b></label>
    {{form::text('start_time', '', ['class' => 'form-control', 'placeholder' => '02:00 PM'])}}
  </div>

  <div class="form-group form-float">
    <label for="end_time"><b>End time</b></label>
    {{form::text('end_time', '', ['class' => 'form-control', 'placeholder' => '06:00 MM'])}}
  </div>
  <!-- Managing photo -->
  <div class="container-fluid">
    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
          <div class="body" class="dropzone">
            <div class="dz-message">
              <div class="drag-icon-cph"> <i class="material-icons">touch_app</i> </div>
              <h3>Invitation upload</h3>
              <em>Please upload a photo of your invitation. It will be used for verifying their identity at the entrance to
                parties. It must be in <strong>PNG, JPEG or JPG format</strong> and <font color='red'><em>no larger than 2Mb</em></font>. If you are having trouble, please be
                patient as it can take a minute or two if you have a slow internet connection. You can also try using a
                different web browser e.g. Google Chrome, Safari or Mozilla Firefox. If you are still having issues,
                please contact <a href="mailto:webmaster@lefrenchrallye.com">webmaster@lefrenchrallye.com</a></em>
            </div>
            <div class="fallback">
              <input name="invitationFile" id="file" type="file" onchange="Filevalidation()" multiple required /><span id="size"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Managing photo -->

  <div class="form-group form-float">
    <label for="title"><b>Invitation upload</b></label>
  </div>

  <a href="/home" class="btn btn-default float-right">Go back </a>
  {{form::submit('Upload the invitation', ['class' => 'btn btn-primary'])}}
  {{ Form::close() }}
</div>
<hr>

<a href={{secure_url("/sendInvitationToMyself")}}><button type="button" class="btn btn-primary btn-md"><span
  class="glyphicon glyphicon-plus"></span> Send test to myself</button></a>

<a href="{{secure_url("/mails/$application->id")}}"><button type="button" class="btn btn-primary btn-md"><span
  class="glyphicon glyphicon-plus"></span> Send to all rallyes members/Invitation already sent</button></a>


<!-- For Material Design Colors -->
<div class="modal fade" id="underConstruction" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content bg-pink">
          <div class="modal-header">
              <h4 class="title" id="defaultModalLabel">UNDER CONSTRUCTION</h4>
          </div>
          <div class="modal-body col-white"> This option is under construction, please try it later on!</div>
          <div class="modal-footer">
              <!--<button type="button" class="btn btn-link waves-effect col-white">SAVE CHANGES</button>-->
              <button type="button" class="btn btn-link waves-effect col-white" data-dismiss="modal">CLOSE</button>
          </div>
      </div>
  </div>
</div>
<!--END MODAL -->
@stop
@section('page-script')
<script src="{{secure_asset('assets/js/pages/forms/form-fileSize-validation.js')}}"></script>

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
