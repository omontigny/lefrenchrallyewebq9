@extends('layout.master')
@section('title', 'Rallyes')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')
@if(count($rallyes) > 0)
<div class="container-fluid">

    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <a href={{secure_url("/rallyes/create")}}><button type="button" class="btn btn-primary btn-md float-right"><span class="glyphicon glyphicon-plus"></span> Add new</button></a>
                    <h2><strong>Rallyes</strong> List</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                    <table class="table dataTable js-exportable">
                        <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                            <thead class="thead-dark">
                                <tr>
                                    <th width="20px;">#</th>
                                    <th>Title</th>
                                    <th>Petit Rallye</th>
                                    <th width="40px;">Status</th>
                                    <th style="width:100px;" >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                          @foreach ($rallyes as $rallye)
                                @switch($rallye->status)
                                          @case(false)
                                            <tr class="table-danger">
                                            @break
                                          @case(true)
                                              <tr class="table-success">
                                              @break
                                 @endswitch
                                    <td>{{$rallye->id}}</td>
                                    <td><strong>{{$rallye->title}}</strong></td>
                                    @if($rallye->isPetitRallye)
                                      <td><strong>Yes</strong></td>
                                    @else
                                      <td></td>
                                    @endif
                                    @if($rallye->status)
                                      <td><strong>Opened</strong></td>                                    
                                    @else
                                      <td><strong>Closed</strong></td>
                                    @endif
                                    <td> 
                                        <a href="/rallyes/{{$rallye->id}}/reverseStatusById"><button type="button" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-flash"></span></button></a>
                                        <a href="/rallyes/{{$rallye->id}}/edit"><button type="button" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit"></span></button></a>
                                        <a href="/rallyes/{{$rallye->id}}"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon  glyphicon-info-sign"></span></button></a>
                                        <button type="button" class="btn btn-danger btn-sm  " data-toggle="modal" data-target="#deleteRallyeModal"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                </tr>
                        @endforeach
                          </tbody>
                            <!--<tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Level</th>
                                    <th>Edit</th>
                                    <th>Show</th>
                                    <th>Delete</th>
                                </tr>
                            </tfoot>-->
                        </table>
                        </div>
                </div>
                {{$rallyes->links()}}
            </div>
        </div>
        
    </div>
    <!-- #END# Exportable Table --> 
    
</div>

<!-- +AJO : Model section begin -->
<div class="modal fade" id="deleteRallyeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="title col-white text-center" id="defaultModalLabel">Delete Rallye confirmation</h4>
            </div>
            <div class="modal-body col-white">
                {{ Form::open(['action' => ['RallyesController@destroy', $rallye->id], 'method' => 'POST']) }}  
                @csrf
                {{Form::hidden('_method', 'DELETE')}}
                <div class="form-group">
                    <label for="rallye_id"><b>Please enter the rally's title to delete</b></label>
                    {{form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
                  </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-link waves-effect col-white">Delete</button>
                <button type="button" class="btn btn-link waves-effect col-white" data-dismiss="modal">No, Cancel</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
  </div>
  <!-- +AJO : Model section end -->
  @else
        <p> No rallyes found </p>
        <a href={{secure_url("/rallyes/create")}}><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> Add new</button></a>
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

