@extends('layout.master')
@section('title', 'Control Panel')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}" />
<link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}" />

{{-- ## TinyMCE ##  --}}

<script src="https://cdn.tiny.cloud/1/{{env('TINY_API_KEY')}}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
{{-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> --}}
<script>tinymce.init({
  selector:'#myTextarea2',
  height: 350,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
  ],
  toolbar: 'undo redo | formatselect | ' +
  'bold italic underline strikethrough forecolor backcolor | '+
  'alignleft aligncenter alignright alignjustify | ' +
  'fontselect fontsizeselect formatselect | ' +
  'bullist numlist outdent indent | ' +
  'removeformat | help',
  toolbar_mode: 'sliding',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
 });</script>
{{-- <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script> --}}

{{-- ## CKEditor ##  --}}
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/decoupled-document/ckeditor.js"></script> --}}


@stop
@section('content')
<h3><span class="glyphicon glyphicon-pushpin"></span> Control Panel</h3>
<hr>


@include('controlPanel.testMails')

@include('controlPanel.administrators', $userRoles)

@include('controlPanel.specialAccess', $specialAccess)

@include('controlPanel.accessControl', $accessControl)


  @stop
  @section('page-script')
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
