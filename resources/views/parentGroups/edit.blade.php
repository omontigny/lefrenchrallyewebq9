@extends('layout.master')
@section('title', 'Adding Parent to groups')
@section('parentPageTitle', 'Admin')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/multi-select/css/multi-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-spinner/css/bootstrap-spinner.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/nouislider/nouislider.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/select2/select2.css')}}">
@stop
@section('content')
<div class='container'>
{{ Form::open(['action' => ['ParentGroupsController@update', $parentGroup->id], 'method' => 'POST']) }}
@csrf
{{Form::hidden('_method', 'PUT')}}
                
    <div class="form-group form-float"> 
        <label for="child_id"><b>Child</b></label>
        <select class="form-control show-tick ms select2" data-placeholder="Select" name="child_id" required>
        <option value="" selected disabled>-- Please select a child--</option>
          @foreach ($children as $child)
            <option value={{$child->id}}
                @if ($parentGroup->parent->id === $child->parent_id)
                    selected
                @endif
                  >{{$child->childfirstname}} {{$child->childlastname}}</option>
          @endforeach
        </select>
        <div class="help-info"> 
        <p>Please select the targetted child</p>
      </div>
    </div>

    
  
  <fieldset>                  
      <div class="form-group form-float"> 
        <label for="group_id"><b>Rallye group</b></label>
        <select class="form-control show-tick ms select2" data-placeholder="Select" name="group_id" required>
        <option value="" selected disabled>-- Please select a rallye's group --</option>
          @foreach ($groups as $group)
            <option value={{$group->id}}
                @if ($parentGroup->group->id === $group->id)
                    selected
                @endif
                  >{{$group->name}}</option>
          @endforeach
        </select>
        <div class="help-info"> 
        <p>Please select the targetted rallye's group</p>
      </div>
    </div>
         
                            
                          
        
    
  {{form::submit('Update', ['class' => 'btn btn-primary'])}}
  <a href="/parentGroups" class="btn btn-default float-right">Go back </a>
{{ Form::close() }}
</div>
@stop
@section('page-script')
<script src="{{secure_asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
<script src="{{secure_asset('assets/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-spinner/js/jquery.spinner.js')}}"></script>
<script src="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<script src="{{secure_asset('assets/plugins/nouislider/nouislider.js')}}"></script>
<script src="{{secure_asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
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