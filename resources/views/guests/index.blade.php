@extends('layout.master')
@section('title', 'Apply')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}"/>
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}"/>
@stop
@section('content')
<h3><span class="glyphicon glyphicon-user"></span> Extra Guests</h3>
<hr>
<p><b>Extra Guest Rules</b></p>
<ol>
  <li>A children can invite only 1 extra guest per event.</li>
  <li>A children can invite only 2 extra guests in total.</li>
  <li>One specific extra guest can participate only twice a year.</li>
</ol>
<hr>
<h3>Add a new Extra Guest</h3>
<p>Below, you can enter the information about the guest </p>
<div class='container'>
  {{ Form::open(['action' => 'GuestsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
  @csrf
  <div class="form-group form-float">
    <label for="group_id"><b>Event date available<span class="text-danger"> *</span></b></b></label>
     <select class="form-control show-tick ms select2" data-placeholder="Select" name="group_id" required>
      @if(count($availableGroupIds) > 0)
        <option value="" selected disabled>-- Please select a group - event date --</option>
        @foreach ($groups as $group)
          @foreach($availableGroupIds as $availableGroupId)
              @if($group->id == $availableGroupId)
                <option value={{$group->id}}>{{$group->rallye->title . ' ' . $group->name . ' ' . \Illuminate\Support\Carbon::parse($group->eventDate)->format('d-m-Y')}}</option>
              @endif
          @endforeach
        @endforeach
      @else
        <option value="" selected disabled>-- No event date available --</option>
      @endif
    </select>
  </div>

  <div class="form-group form-float">
    <label for="first_name"><b>First Name<span class="text-danger"> *</span></b></label>
    {{form::text('first_name', '', ['class' => 'form-control', 'placeholder' => 'First Name', 'pattern'=> "^[ A-Za-z0-9_.-]*$", 'required'])}}
    <div class="help-info">You need to enter your guest child's first name without accent. Avoid some special caracters like (&\/$€`()[]@#+%?!~). You can use (-_.)</div>
  </div>

   <div class="form-group form-float">
    <label for="last_name"><b>Last Name<span class="text-danger"> *</span></b></label>
    {{form::text('last_name', '', ['class' => 'form-control', 'placeholder' => 'Last Name', 'required'])}}
    <div class="help-info">You need to enter your guest child's last name in capital</div>
  </div>

  <div class="form-group form-float">
    <label for="guest_email"><b>Email<span class="text-danger"> *</span></b></label>
    {{form::text('guest_email', '', ['class' => 'form-control', 'placeholder' => 'name@domain.com', 'pattern' => "^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$", 'required'])}}
    <div class="help-info">You need to enter your guest child's email or parent email</div>
  </div>

  <div class="form-group form-float">
    <label for="guest_mobile"><b>Guest Parent Mobile Phone<span class="text-danger"> *</span></b></label>
    {{form::text('guest_parentmobile', '', ['class' => 'form-control', 'placeholder' => '+33122334455', 'pattern' => "^(?:(?:\+|00)(33|44|1))\s*[1-9](?:[\s.-]*\d{2,}){4}$", 'required'])}}
    <div class="help-info">You need to enter your guest child's legal representative mobile phone</div>
  </div>

  <div class="form-group form-float">
    <label for="guest_mobile"><b>Guest Mobile Phone</b></label>
    {{form::text('guest_mobile', '', ['class' => 'form-control', 'placeholder' => '+33122334455', 'pattern' => "^(?:(?:\+|00)(33|44|1))\s*[1-9](?:[\s.-]*\d{2,}){4}$"])}}
    <div class="help-info">You need to enter your guest child's mobile</div>
  </div>

  <a href="/home" class="btn btn-default float-right">Go back </a>
  {{form::submit('Add Extra Guest', ['class' => 'btn btn-primary'])}}
  {{ Form::close() }}
</div>
<hr>

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
