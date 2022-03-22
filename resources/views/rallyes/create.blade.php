@extends('layout.master')
@section('title', 'Application')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/plugins/dropzone/dropzone.css')}}">

<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/multi-select/css/multi-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-spinner/css/bootstrap-spinner.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/nouislider/nouislider.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/select2/select2.css')}}">

<link href="{{secure_asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
<link href="{{secure_asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet">


@stop
@section('content')
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="body">
        {{ Form::open(['action' => 'RallyesController@store', 'method' => 'GET']) }}
        @csrf

        <div class="form-group form-float ">
          <label for="title"><b>Rallye title</b></label>
          <input type="text" name="title" placeholder="Rallye title" class="form-control" required>
          <div class="help-info">
            <p>You need to enter your first name.</p>
          </div>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="isPetitRallye" name="isPetitRallye" value="true">
          <label class="form-check-label" for="isPetitRallye"><b>is Petit Rallye?</b></label>
        </div>
        <br />
        <div class="form-group form-float ">
          <label for="rallyemail"><b>Rallye email</b></label>
          <input type="mail" name="rallyemail" placeholder="Rallye email" class="form-control">
          <div class="help-info">
            <p>You need to enter an email for this rallye</p>
          </div>
        </div>

           {{form::submit('Submit', ['class' => 'btn-block btn-primary'])}}
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@stop
@section('page-script')

<script src="{{secure_asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{secure_asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>


<script src="{{secure_asset('assets/plugins/dropzone/dropzone.js')}}"></script>
<script src="{{ secure_asset('assets/js/date-input-polyfill.dist.js') }}"></script>
<script src="{{secure_asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
<script src="{{secure_asset('assets/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-spinner/js/jquery.spinner.js')}}"></script>
<script src="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<script src="{{secure_asset('assets/plugins/nouislider/nouislider.js')}}"></script>
<script src="{{secure_asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
<script>
  $(function() {              
           // Bootstrap DateTimePicker v4
           
           $('#date').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY', weekStart : 0, time: false });
           $('#date1').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY', weekStart : 0, time: false });
           $('#date2').bootstrapMaterialDatePicker({  format : 'DD/MM/YYYY', weekStart : 0, time: false });
          
        });      

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