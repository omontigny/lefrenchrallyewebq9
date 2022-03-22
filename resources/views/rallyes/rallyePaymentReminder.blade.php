@extends('layout.master')
@section('title', 'my Rallyes - Payment Reminder')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop
@section('content')

@if(count($applications) > 0 )
  
<div class="container-fluid">
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12">
            <div>  
          <div class="card">
                <div class="header">
                    <h2><strong>My rallye</strong> Payment reminder list</h2>
                    @if(Auth::user()->active_profile == Config::get('constants.roles.COORDINATOR') || Auth::user()->active_profile == Config::get('constants.roles.SUPERADMIN'))
                    <!-- MAIL -->
                    <a href="paymentReminderEmail"><button type="button" class="btn btn-warning btn-sm float-right"><span class="glyphicon glyphicon-envelope"></span> Mail</button></a>
                    <!-- MAIL -->
                  @endif
    
                  </div>
                <div class="body">
                    <div class="table-responsive">
                    <table class="table dataTable js-exportable">
                        <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                            <thead class="thead-dark">
                                <tr>
                                    <th>To</th>
                                    <th>ID</th>
                                    <th>Child</th>
                                    <th>Rallye</th>
                                    <th>Parent</th>
                                    <th>Email</th>
                                    <th>Home phone</th>
                                    <th>mobile</th> 
                                </tr>
                            </thead>
                            <tbody>
                          @foreach ($applications as $application)
                                <tr>
                                  <td> 
                                    <a href="/applicationExtra/{{$application->id}}/ActivateMailto"><button type="button" class="btn 
                                      @if($application->mailto)
                                      btn-success  
                                    @else
                                    btn-danger                                    
                                     
                                    @endif  
                                              btn-sm"><span class="glyphicon glyphicon-flash"></span></button></a>
                                </td>
                                  <td><b>{{$application->id}}</b></td>  
                                  <td><b>{{$application->childfirstname . ' ' . $application->childlastname}}</b></td>
                                    <td><b>{{$application->rallye->title}}</b></td>
                                    <td><b>{{$application->parentfirstname . ' ' . $application->parentlastname}}</b></td>
                                    <td><b><a href="mailto:{{$application->parentemail}}">{{$application->parentemail}}</a></b></td>
                                    <td><b><a href="tel:{{$application->parenthomephone}}">{{$application->parenthomephone}}</a></b></td>
                                    <td><b><a href="sms:{{$application->parentmobile}}">{{$application->parentmobile}}</a></b></td>
                                   
                                </tr>
                        @endforeach
                          </tbody>
                        </table>
                        </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- #END# Exportable Table --> 
    
</div>
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

