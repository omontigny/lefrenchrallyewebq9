@extends('layout.master')
@section('title', 'Coordinators')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/sweetalert/sweetalert.css')}}" />
@stop
@section('content')
@if(count($coordinators) > 0)
<div class="container-fluid">

    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <a href={{secure_url("/coordinators/create")}}><button type="button"
                            class="btn btn-primary btn-md float-right"><span class="glyphicon glyphicon-plus"></span>
                            Add new</button></a>
                    <h2><strong>Coordinators</strong> List</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table dataTable js-exportable">
                            <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                            <thead class="thead-dark">
                                <tr>
                                    <th width="20px;">#</th>
                                    <th>Username</th>
                                    <th>Last name</th>
                                    <th>First name</th>
                                    <th>E-mail</th>
                                    <th>Status</th>
                                    <th style="width:100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coordinators as $coordinator)
                                <tr>
                                    <td>{{$coordinator->id}}</td>
                                    <td><strong>{{$coordinator->username}}</strong></td>
                                    <td><strong>{{$coordinator->lastname}}</strong></td>
                                    <td><strong>{{$coordinator->firstname}}</strong></td>
                                    <td><strong>{{$coordinator->mail}}</strong></td>
                                    @switch($coordinator->status)
                                    @case(1)
                                    <td><strong>activated</strong></td>
                                    @break

                                    @case(2)
                                    <td><strong>Desactived</strong></td>
                                    @break
                                    @case(3)
                                    <td><strong>Pwd-Reset</strong></td>
                                    @break
                                    @case(4)
                                    <td><strong>Engaged</strong></td>
                                    @break
                                    @case(5)
                                    <td><strong>Ready</strong></td>
                                    @break
                                    @default
                                    <td><strong>Initialized</strong></td>
                                    @endswitch
                                    <td>
                                        <a href="coordinators/{{$coordinator->id}}"><button type="button"
                                                class="btn btn-warning btn-sm"><span
                                                    class="glyphicon glyphicon-edit"></span></button></a>
                                        <a href="/coordinators/{{$coordinator->id}}/resetCoordinatorPasswordById"><button
                                                type="button" class="btn btn-dark btn-sm"><span
                                                    class="glyphicon glyphicon-repeat"></span></button></a>
                                        <a href="/coordinators/{{$coordinator->id}}"><button type="button"
                                                class="btn btn-primary btn-sm"><span
                                                    class="glyphicon glyphicon-info-sign"></span></button></a>
                                        <button type="button" class="btn btn-danger btn-sm  " data-toggle="modal"
                                            data-target="#deleteCoordinatorModal_{{$coordinator->id}}"><span
                                                class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                    <!-- +AJO : Model section begin -->
                                    <div class="modal fade" id="deleteCoordinatorModal_{{$coordinator->id}}" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content bg-danger">
                                                <div class="modal-header">
                                                    <h4 class="title col-white text-center" id="defaultModalLabel">
                                                        Delete Coordinator confirmation</h4>
                                                </div>
                                                <div class="modal-body col-white">
                                                    {{ Form::open(['method' => 'GET', 'url' => route('coordinators.destroy', $coordinator->id)]) }}
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <p><b>Coordinator: </b>{{$coordinator->firstname}} {{$coordinator->lastname}}</p>

                                                    <div class="form-group">
                                                        <label for="action"><b>Are you sure you want to delete this
                                                                coordinator ?</b></label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-link waves-effect col-white">Delete</button>
                                                    <button type="button" class="btn btn-link waves-effect col-white"
                                                        data-dismiss="modal">No,
                                                        Cancel</button>
                                                </div>
                                                {{ Form::close() }}
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
                {{$coordinators->links()}}
            </div>
        </div>

    </div>
    <!-- #END# Exportable Table -->

</div>

@else
<p> No coordinators found </p>
<a href={{secure_url("/coordinators/create")}}><button type="button" class="btn btn-primary btn-md"><span
            class="glyphicon glyphicon-plus"></span> Add new</button></a>
@endif
<br />
@stop
@section('page-script')

<script>

</script>

<script src="{{secure_asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/ui/dialogs.js')}}"></script>

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