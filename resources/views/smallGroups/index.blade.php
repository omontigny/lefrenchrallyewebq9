@extends('layout.master')
@section('title', 'Groups')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
@stop
@section('content')
@if(count($groups) > 0)
<div class="container-fluid">

  <!-- Exportable Table -->
  <div class="row clearfix">
    <div class="col-lg-12">
      <div class="card">
        <div class="header">
          <a href={{secure_url("/smallgroups/create")}}><button type="button"
              class="btn btn-primary btn-md float-right"><span class="glyphicon glyphicon-plus"></span> Add
              new</button></a>
          <h2><strong>Groups</strong> List</h2>
        </div>
        <div class="body">
          <div class="table-responsive">
            <table class="table dataTable js-exportable">
              <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
              <thead class="thead-dark">
                <tr>
                  <th width="20px;">#</th>
                  <th>Rallye title</th>
                  <th>Petit Rallye</th>
                  <th>Group name</th>
                  <th>Event date (DD-MM-YYYY)</th>
                  <th style="width:100px;">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($groups as $group)
                  @if($group->rallye->isPetitRallye)
                    <tr>
                      <td>{{$group->id}}</td>
                      <td><strong>{{$group->rallye->title}} {{ $group->start_year}}/{{ $group->end_year}}</strong></td>
                      @if($group->rallye->isPetitRallye)
                        <td><strong>Yes</strong></td>
                      @else
                        <td></td>
                      @endif
                      <td><strong>{{$group->name}}</strong></td>
                      @if($group->eventDate != null)
                        <td><strong>{{\Illuminate\Support\Carbon::parse($group->eventDate)->format('d-m-Y')}}</strong></td>
                      @else
                        <td></td>
                      @endif

                      <td>
                        <a href="/smallgroups/{{$group->id}}"><button type="button" class="btn btn-warning btn-sm"><span
                              class="glyphicon glyphicon-edit"></span></button></a>
                        <a href="/smallgroups/{{$group->id}}/showGroupMembersSameApplicationGroupName"><button type="button"
                            class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-info-sign"></span></button></a>
                        <a href="/smallgroups/{{$group->id}}/showGroupMembersSameApplicationEvent"><button type="button"
                            class="btn btn-dark btn-sm"><span
                              class="glyphicon glyphicon-menu-hamburger"></span></button></a>
                        <button type="button" class="btn btn-danger btn-sm  " data-toggle="modal"
                          data-target="#deleteGroupModal_{{$group->id}}"><span
                            class="glyphicon glyphicon-remove"></span></button>
                      </td>
                    </tr>
                    <!-- +AJO : Model section begin -->
                    <div class="modal fade" id="deleteGroupModal_{{$group->id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content bg-danger">
                          <div class="modal-header">
                            <h4 class="title col-white text-center" id="defaultModalLabel">Delete group confirmation</h4>
                          </div>
                          <div class="modal-body col-white">
                            {{ Form::open(['method' => 'GET', 'url' => route('smallgroups.destroy', $group->id)]) }}
                            @csrf
                            {{ method_field('DELETE') }}
                            <p><b>Group: </b>{{$group->name}}</p>

                            <div class="form-group">
                              <label for="action"><b>Are you sure you want to delete this group ?</b></label>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect col-white">Delete</button>
                            <button type="button" class="btn btn-link waves-effect col-white" data-dismiss="modal">No,
                              Cancel</button>
                          </div>
                          {{ Form::close() }}
                        </div>
                      </div>
                    </div>
                    <!-- +AJO : Model section end -->
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        {{$groups->links()}}
      </div>
    </div>

  </div>
  <!-- #END# Exportable Table -->

</div>
@else
<p> No groups found </p>
<a href={{secure_url("/smallgroups/create")}}><button type="button" class="btn btn-primary btn-md"><span
      class="glyphicon glyphicon-plus"></span> Add new</button></a>
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
          $(this).children("ul").stop(true, false).fadeToggle(150);gro
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
