@extends('layout.master')
@section('title', 'School years')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@stop
@section('content')
@if(count($schoolYears) > 0)
<div class="container-fluid">

    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <a href={{secure_url("/schoolyears/create")}}><button type="button" class="btn btn-primary btn-md float-right"><span class="glyphicon glyphicon-plus"></span> Add new</button></a>
                    <h2><strong>School years</strong> List</h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                    <table class="table dataTable js-exportable">
                        <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                            <thead class="thead-dark">
                                <tr>
                                    <th width="20px;">#</th>
                                    <th>Current School year</th>
                                    <th>Next School year</th>
                                    <th style="width:60px;" >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                          @foreach ($schoolYears as $schoolYear)
                                <tr>
                                    <td>{{$schoolYear->id}}</td>
                                    <td><strong>{{$schoolYear->current_level}}</strong></td>
                                    <td><strong>{{$schoolYear->next_level}}</strong></td>
                                    <td> 
                                        <a href="schoolyears/{{$schoolYear->id}}"><button type="button" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit"></span></button></a>
                                        <button type="button" class="btn btn-danger btn-sm  " data-toggle="modal"
                      data-target="#deleteSchoolYearModal_{{$schoolYear->id}}"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                </tr>
                                <!-- +AJO : Model section begin -->
<div class="modal fade" id="deleteSchoolYearModal_{{$schoolYear->id}}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
      <div class="modal-content bg-danger">
          <div class="modal-header">
              <h4 class="title col-white text-center" id="defaultModalLabel">Delete school year confirmation</h4>
          </div>
          <div class="modal-body col-white">
            {{ Form::open(['method' => 'GET', 'url' => route('schoolyears.destroy', $schoolYear->id)]) }}
            @csrf
            {{Form::hidden('_method', 'DELETE')}}
            <div class="form-group">
                <label for="schoolYear_id"><b>Do you really want to delete the role {{$schoolYear->current_level}}?</b></label>
                <input name="schoolYear_id" type="hidden" value="{{$schoolYear->id}}">
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
<!-- +AJO : Model section end -->

                        @endforeach
                          </tbody>
                          
                        </table>
                        </div>
                </div>
                {{$schoolYears->links()}}
            </div>
        </div>
        
    </div>
    <!-- #END# Exportable Table --> 
    
</div>
  @else
        <p> No school year found </p>
        <a href={{secure_url("/schoolyears/create")}}><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> Add new</button></a>
    @endif
    <br />
@stop
@section('page-script')
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

