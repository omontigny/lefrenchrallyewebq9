@extends('layout.master')
@section('title', 'Rallyes')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/sweetalert/sweetalert.css')}}" />
@stop
@section('content')
<!-- ACTIVE RALLYE -->

@if(count($articles) > 0)
<div class="container-fluid">

  <!-- Exportable Table -->
  <div class="row clearfix">
    <div class="col-lg-12">
      <div class="card">
        <div class="header">
          <a href={{secure_url("/rallyes/create")}}><button type="button"
              class="btn btn-primary btn-md float-right"><span class="glyphicon glyphicon-plus"></span> Add
              new</button></a>
          <h2><strong>Rallyes</strong> List</h2>
        </div>
        <div class="body">
          <div class="table-responsive">
            <table class="table dataTable js-exportable">
              <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
              <thead class="thead-dark">
                <tr>
                  <th>Title</th>
                  <th width="100px;">Petit Rallye</th>
                  <th>E-mail</th>
                  <th width="40px;">Status</th>
                  <th style="width:100px;">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($articles as $article)
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <a href="/rallyes/{{$article}}/reverseStatusById"><button type="button"
                        class="btn btn-info btn-sm"><span class="glyphicon glyphicon-flash"></span></button></a>
                    <a href="/rallyes/{{$article}}/edit"><button type="button" class="btn btn-warning btn-sm"><span
                          class="glyphicon glyphicon-edit"></span></button></a>
                    <button type="button" class="btn btn-danger btn-sm  " data-toggle="modal"
                      data-target="#deleteRallyeModal_{{$article->id}}"><span class="glyphicon glyphicon-remove"></span></button>
                  </td>
                  <!-- +AJO : Model section begin -->
                  <div class="modal fade" id="deleteRallyeModal_{{$article->id}}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content bg-danger">
                        <div class="modal-header">
                          <h4 class="title col-white text-center" id="defaultModalLabel">Delete Rallye confirmation</h4>
                        </div>
                        <div class="modal-body col-white">
                      
                      </div>
                    </div>
                  </div>
                  <!-- +AJO : Model section end -->

                </tr>
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

<div class="container-fluid">
  <h3>Quick access</h3>
  <a href={{secure_url("/openallrallyes")}}><button type="button" class="btn btn-primary">Open all</button></a>
  <a href={{secure_url("/closeallrallyes")}}><button type="button" class="btn btn-danger float-right">Close
      all</button></a>

</div>
@else
<p> No rallyes found </p>
<a href={{secure_url("/rallyes/create")}}><button type="button" class="btn btn-primary btn-md"><span
      class="glyphicon glyphicon-plus"></span> Add new</button></a>
@endif
<br />

<!--
<h3 class="text-danger">Danger Zone</h3>
<h6 class="text-danger ">This will lead to delete of all rallies, calendars and coordinators data, please make sure before taking this action, this last is irreversible</h6>


<a href={{secure_url("deleteAllRallyes")}}><button type="button" class="btn btn-danger float-right btn-lg">IRREVERSIBLE DELETE</button></a>
-->


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