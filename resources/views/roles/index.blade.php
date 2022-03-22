@extends('layout.master')
@section('title', 'Roles')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')
@if(count($roles) > 0)
<div class="container-fluid">

    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <a href={{secure_url("/roles/create")}}><button type="button" class="btn btn-primary btn-md float-right"><span class="glyphicon glyphicon-plus"></span> Add new</button></a>
                    <h2><strong>Roles</strong> List</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                    <table class="table dataTable js-exportable">
                        <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                            <thead class="thead-dark">
                                <tr>
                                    <th width="20px;">#</th>
                                    <th>Role Name</th>
                                    <th   style="width:60px;" >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                          @foreach ($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td><strong>{{$role->rolename}}</strong></td>
                                    <td> 
                                        <a href="/roles/{{$role->id}}"><button type="button" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit"></span></button></a>
                                        <!--<a href="/roles/{{$role->id}}"><button type="button" class="btn btn-primary btn-sm"><span class="glyphicon  glyphicon-info-sign"></span></button></a>-->
                                    <button type="button" class="btn btn-danger btn-sm  " data-toggle="modal" data-target="#deleteRoleModal_{{$role->id}}"><span class="glyphicon glyphicon-remove"></span></button>
                                        <!--<button type="button" class="btn btn-danger btn-sm  "><span class="glyphicon glyphicon-remove"></span></button>-->
                                    </td>
                                </tr>
                                <!-- +AJO : Model section begin -->
                                <div class="modal fade" id="deleteRoleModal_{{$role->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content bg-danger">
                                            <div class="modal-header">
                                                <h4 class="title col-white text-center" id="defaultModalLabel">Delete Role confirmation</h4>
                                            </div>
                                              <div class="modal-body col-white">
                                                  {{ Form::open(['method' => 'GET', 'url' => route('roles.destroy', $role->id)]) }}
                                                  @csrf
                                                  {{Form::hidden('_method', 'DELETE')}}
                                                  <div class="form-group">
                                                      <label for="role_id"><b>Do you really want to delete the role {{$role->rolename}}?</b></label>
                                                      <input name="role_id" type="hidden" value="{{$role->id}}">
                                                    </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="submit" class="btn btn-link waves-effect col-white">Yes, delete</button>
                                                  <button type="button" class="btn btn-link waves-effect col-white" data-dismiss="modal">No, cancel</button>
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
                <!-- Pagination goes here-->
            </div>
        </div>
        
    </div>
    <!-- #END# Exportable Table --> 
    
</div>


  @else
        <p> No roles found </p>
        <a href={{secure_url("/roles/create")}}><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> Add new</button></a>
    @endif
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

