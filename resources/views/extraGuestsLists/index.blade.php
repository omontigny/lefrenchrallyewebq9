@extends('layout.master')
@section('title', 'ExtraGuestsList')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}" />
@stop
@section('content')
<h3><span class="glyphicon glyphicon-list"></span> Extra Guest List</h3>
<hr>

<!-- Exportable Table -->
@if(count($extracheckins) > 0)
<p>Find below the liste of the Extra Guests children for all the events of the year for the current rallye.</p>
<!--{{var_dump($extracheckins)}} -->
<div class="row clearfix">
  <div class=""> <!-- Enlarge central pannel to have access to buttons but not centered (old value : col-lg-12 -->
    <div class="card">
      <div class="header">
        <h2><strong>Extra Guest</strong> List</h2>
      </div>
      <div class="body">
        <div class="table-responsive">
          <table class="table dataTable js-exportable">
            <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
            <thead class="thead-dark">
            <tr>
              <th>Avatar</th>
              <th>Extra Guest Name</th>
              <th>Extra Guest email</th>
              <th>Extra Guest mobile</th>
              <th>Invited by Parent Name</th>
              <th>Group Name</th>
              <th>Event Date (DD-MM-YYYY)</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>
              @foreach ($extracheckins as $extracheckin)
                <tr class="bg-muted text-muted">
                  <td>
                    <div class="media-object">
                      <img src="../assets/images/default_avatar.jpg" alt="" width="35" class="rounded-circle">
                    </div>
                  </td>
                  <td><b>{{$extracheckin->guestfirstname . ' ' . $extracheckin->guestlastname}}</b></td>
                  <td><b>{{$extracheckin->guestemail}}</b></td>
                  <td><b><a href="sms:{{$extracheckin->guestmobile}}">{{$extracheckin->guestmobile}}</a></b></td>
                  <td><b>{{$extracheckin->parentfirstname . ' ' . $extracheckin->parentlastname}}</b></td>
                  @if($extracheckin != null)
                    <td><b>{{$extracheckin->group_name}}</b></td>
                    <td><strong>{{\Illuminate\Support\Carbon::parse($extracheckin->eventDate)->format('d-m-Y')}}</strong></td>
                  @else
                    <td>-</td>
                  @endif
                  <td>
                    <div class="align-center">
                      <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#EditExtraGuestModal_{{$extracheckin->id}}"><span class="glyphicon glyphicon-edit"></span><b></b></button>
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#DeletingExtraGuestModal_{{$extracheckin->id}}"><span class="glyphicon glyphicon-remove"></span><b></b></button>
                    </div>
                  </td>

                  <!-- +AJO : Modal delete section begin -->
                  <div class="modal fade" id="DeletingExtraGuestModal_{{$extracheckin->id}}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content bg-danger">
                        <div class="modal-header">
                          <h4 class="title col-white text-center" id="defaultModalLabel">Delete Extra Guest</h4>
                        </div>
                        <div class="modal-body col-white">
                          {{ Form::open(['method' => 'GET', 'url' => route('extraguestslist.destroy', $extracheckin->id)]) }}
                          @csrf

                          <p for=""><b>Rallye: </b>{{$extracheckin->rallye_title}}</p>
                          <p for=""><b>First Name: </b>{{$extracheckin->guestfirstname}}</p>
                          <p for=""><b>Last Name: </b>{{$extracheckin->guestlastname}}</p>
                          <p for=""><b>Groupe Name: </b>{{$extracheckin->group_name}}</p>
                          <p for=""><b>Event Date: </b>{{\Illuminate\Support\Carbon::parse($extracheckin->eventDate)->format('d-m-Y')}}

                          <div class="form-group">
                              <label for="action"><b>Are you sure you want to delete this Extra Guest ?</b></label>
                          </div>
                        </div>
                        {{Form::hidden('_method', 'DELETE')}}
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-link waves-effect col-white">Yes</button>
                          <button type="button" class="btn btn-link waves-effect col-white" data-dismiss="modal">No, cancel</button>
                        </div>
                        {{ Form::close() }}
                      </div>
                    </div>
                  </div>
                  <!-- END MODAL DELETE -->

                  <!-- +AJO : Modal EDIT section begin -->
                  <div class="modal fade" id="EditExtraGuestModal_{{$extracheckin->id}}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="title text-center" id="defaultModalLabel">Edit Extra Guest</h4>
                          </div>

                          <div class="modal-body">
                              {{ Form::open(['method' => 'GET', 'url' => route('extraguestslist.update', $extracheckin->id)]) }}
                              @csrf

                              <p for=""><b>Rallye: </b>{{$extracheckin->rallye_title}}</p>
                              <p for=""><b>Groupe Name: </b>{{$extracheckin->group_name}}</p>
                              <p for=""><b>Event Date: </b>{{\Illuminate\Support\Carbon::parse($extracheckin->eventDate)->format('d-m-Y')}}


                              <div class="form-group">
                                {!! Html::decode(Form::label('guest_firstname','<b>Guest First Name</b>')) !!}
                                {{form::text('guest_firstname', $extracheckin->guestfirstname, ['class' => 'form-control', 'placeholder' => 'first name', 'pattern' => "^[ A-Za-z0-9_.-]*$", 'required'])}}
                                <div class="help-info"><p>Avoid some special caracters like (&\/$€`()[]@#+%?!~). You can use (-_.)</p></div>
                              </div>
                              <div class="form-group form-float">
                                {!! Html::decode(Form::label('guest_lastname','<b>Guest Last Name</b>')) !!}
                                {{form::text('guest_lastname', $extracheckin->guestlastname, ['class' => 'form-control', 'placeholder' => 'Theme/Dress Code', 'required'])}}
                              </div>

                              <div class="form-group form-float">
                                {!! Html::decode(Form::label('guest_email','<b>Guest Email</b>')) !!}
                                {{form::text('guest_email', $extracheckin->guestemail, ['class' => 'form-control', 'placeholder' => 'name@domain.com', 'pattern' => "^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$", 'required'])}}
                                <div class="help-info">You need to enter your guest child's email or parent email</div>
                              </div>

                              <div class="form-group form-float">
                                {!! Html::decode(Form::label('guest_mobile','<b>Guest Mobile Phone</b>')) !!}
                                {{form::text('guest_mobile', $extracheckin->guestmobile, ['class' => 'form-control', 'placeholder' => '+33122334455', 'pattern' => "^(?:(?:\+|00)(33|44|1))\s*[1-9](?:[\s.-]*\d{2,}){4}$", 'required'])}}
                                <div class="help-info">You need to enter your guest child's mobile phone or parent's child mobile phone</div>
                              </div>


                              <input name="guest_id" type="hidden"
                                  value="{{$extracheckin->id}}">
                              <div class="modal-footer">
                                  {{form::submit('Update', ['class' => 'btn btn-primary'])}}
                                  <button type="button" class="btn btn-default float-right"
                                      data-dismiss="modal">Cancel</button>
                              </div>
                              {{ Form::close() }}
                          </div>
                        </div>
                      </div>
                      <!-- END MODAL EDIT -->
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@else
  <p> No Extra Guest for this Rallye </b>
@endif
<!-- #END# Exportable Table -->
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
