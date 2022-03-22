@extends('layout.master')
@section('title', 'Small Menu')
@section('parentPageTitle', 'Layout Format')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.min.css')}}">
@stop
@section('content')
<div class="container-fluid home">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12">
            <div class="card bg-dark">
                <div class="header">
                    <h2><strong>Feeds</strong> <small>Description text here...</small></h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <ul class="list-unstyled feeds_widget white-bg">
                        <li>
                            <div class="feeds-left"><i class="zmdi zmdi-thumb-up"></i></div>
                            <div class="feeds-body">
                                <h4 class="title">7 New Feedback <small class="float-right text-muted">Today</small></h4>
                                <small>Description text here...</small>
                            </div>
                        </li>
                        <li>
                            <div class="feeds-left"><i class="zmdi zmdi-account-circle"></i></div>
                            <div class="feeds-body">
                                <h4 class="title">New customer <small class="float-right text-muted">10:45</small></h4>
                                <small>Contrary to popular belief, Lorem Ipsum is not simply</small>
                            </div>
                        </li>
                        <li>
                            <div class="feeds-left"><i class="zmdi zmdi-help"></i></div>
                            <div class="feeds-body">
                                <h4 class="title badge badge-warning">Server Warning <small class="float-right text-muted">10:50</small></h4>
                                <small>Lorem Ipsum is simply dummy text.</small>
                            </div>
                        </li>
                        <li>
                            <div class="feeds-left"><i class="zmdi zmdi-check"></i></div>
                            <div class="feeds-body">
                                <h4 class="title badge badge-primary">Issue fixed <small class="float-right text-muted">11:05</small></h4>
                                <small>Description text here...</small>
                            </div>
                        </li>
                        <li>
                            <div class="feeds-left"><i class="zmdi zmdi-shopping-basket"></i></div>
                            <div class="feeds-body">
                                <h4 class="title">7 New orders <small class="float-right text-muted">11:35</small></h4>
                                <small>Description text here...</small>
                            </div>
                        </li>                                   
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Members</strong> Profiles <small>Members Preformance / Monthly Status</small> </h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive members_profiles">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width:60px;">Member</th>
                                    <th>Name</th>
                                    <th>Earnings</th>
                                    <th>Sales</th>                                    
                                    <th>Reviews</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="../assets/images/xs/avatar1.jpg" alt="user" width="40"> </td>
                                    <td>
                                        <a href="javascript:void(0);">Logan</a>
                                    </td>
                                    <td>$420</td>
                                    <td>23</td>                                   
                                    <td>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star-outline"></i>
                                    </td>
                                    <td>
                                        <div class="sparkline" data-type="bar" data-width="97%" data-height="15px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#706bd1">2,6,4,5,6,2,7</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="../assets/images/xs/avatar2.jpg" alt="user" width="40"> </td>
                                    <td>
                                        <a href="javascript:void(0);">Isabella</a>
                                    </td>
                                    <td>$350</td>
                                    <td>16</td>                                   
                                    <td>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star-outline"></i>
                                        <i class="zmdi zmdi-star-outline"></i>
                                    </td>
                                    <td>
                                        <div class="sparkline" data-type="bar" data-width="97%" data-height="15px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#706bd1">8,1,3,4,6,2,7</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="../assets/images/xs/avatar3.jpg" alt="user" width="40"> </td>
                                    <td>
                                        <a href="javascript:void(0);">Jackson</a>
                                    </td>
                                    <td>$201</td>
                                    <td>11</td>                                   
                                    <td>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star-outline"></i>
                                        <i class="zmdi zmdi-star-outline"></i>
                                        <i class="zmdi zmdi-star-outline"></i>
                                    </td>
                                    <td>
                                        <div class="sparkline" data-type="bar" data-width="97%" data-height="15px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#706bd1">2,7,3,5,1,8,6</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="../assets/images/xs/avatar4.jpg" alt="user" width="40"> </td>
                                    <td>
                                        <a href="javascript:void(0);">Victoria</a>
                                    </td>
                                    <td>$651</td>
                                    <td>28</td>                                   
                                    <td>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star-half"></i>
                                    </td>
                                    <td>
                                        <div class="sparkline" data-type="bar" data-width="97%" data-height="15px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#706bd1">2,6,4,5,6,2,7</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="rounded-circle" src="../assets/images/xs/avatar5.jpg" alt="user" width="40"> </td>
                                    <td>
                                        <a href="javascript:void(0);">Lucas</a>
                                    </td>
                                    <td>$300</td>
                                    <td>20</td>                                   
                                    <td>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star"></i>
                                        <i class="zmdi zmdi-star-half"></i>
                                        <i class="zmdi zmdi-star-outline"></i>
                                    </td>
                                    <td>
                                        <div class="sparkline" data-type="bar" data-width="97%" data-height="15px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#706bd1">8,1,2,4,3,7,2</div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12">
            <div class="card project_widget">
                <div class="pw_img">
                    <img class="img-fluid" src="../assets/images/image2.jpg" alt="About the image">
                </div>
                <div class="body">
                    <div class="row pw_content">
                        <div class="col-12 pw_header">
                            <h6>Magazine Design</h6>
                            <small class="text-muted">sQuare  |  Last Update: 12 Dec 2017</small>
                        </div>
                        <div class="col-8 pw_meta">
                            <span>4,870 USD</span>                                
                            <small class="text-danger">17 Days Remaining</small>
                        </div>
                        <div class="col-4">
                            <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#7460ee">2,5,6,3,4,5,5,6,2,1</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card project_widget">
                <div class="pw_img">
                    <img class="img-fluid" src="../assets/images/image4.jpg" alt="About the image">
                </div>
                <div class="body">
                    <div class="row pw_content">
                        <div class="col-12 pw_header">
                            <h6>New Dashboard</h6>
                            <small class="text-muted">sQuare  |  Last Update: 17 Dec 2017</small>
                        </div>
                        <div class="col-8 pw_meta">
                            <span>4,210 USD</span>                                
                            <small class="text-success">Early Dec 2017</small>
                        </div>
                        <div class="col-4">
                            <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#60bafd">2,5,6,3,4,5,5,6,2,1</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card project_widget">
                <div class="pw_img">
                    <img class="img-fluid" src="../assets/images/image3.jpg" alt="About the image">
                </div>
                <div class="body">
                    <div class="row pw_content">
                        <div class="col-12 pw_header">
                            <h6>Mobile App</h6>
                            <small class="text-muted">sQuare  |  Last Update: 21 Dec 2017</small>
                        </div>
                        <div class="col-8 pw_meta">
                            <span>1,870 USD</span>                                
                            <small class="text-danger">10 Days Remaining</small>
                        </div>
                        <div class="col-4">
                            <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#000000">2,3,6,5,4,5,8,7,6,3</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 col-lg-8">
            <div class="card">
                <div class="header">
                    <h2><strong>Data</strong> Managed</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-custom" id="project-progress">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Project</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th class="text-right no-sort">Chart</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Graphic layout for client</td>
                                    <td>
                                        <small class="badge badge-primary">High Priority</small>
                                    </td>
                                    <td>
                                        <div class="progress m-b-5">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="36" aria-valuemin="0" aria-valuemax="100" style="width: 36%;"> <span class="sr-only">36% Complete</span> </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <span class="sparkbar">-7,1,-5,0,3,-1</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Make website responsive</td>
                                    <td>
                                        <small class="badge badge-success">Low Priority</small>
                                    </td>
                                    <td>
                                        <div class="progress m-b-5">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"> <span class="sr-only">60% Complete</span> </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <span class="sparkbar">-3,1,2,0,3,-1</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Clean html/css/js code</td>
                                    <td>
                                        <small class="badge badge-primary">High Priority</small>
                                    </td>
                                    <td>
                                        <div class="progress m-b-5">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"> <span class="sr-only">60% Complete</span> </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <span class="sparkbar">-3,1,2,0,3,-1</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Database optimization</td>
                                    <td>
                                        <small class="badge badge-warning">Normal Priority</small>
                                    </td>
                                    <td>
                                        <div class="progress m-b-5">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="71" aria-valuemin="0" aria-valuemax="100" style="width: 71%;"> <span class="sr-only">71% Complete</span> </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <span class="sparkbar">-3,4,-7,0,3,-3,5,7</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Database migration</td>
                                    <td>
                                        <small class="badge badge-success">Low Priority</small>
                                    </td>
                                    <td>
                                        <div class="progress m-b-5">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%;"> <span class="sr-only">89% Complete</span> </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <span class="sparkbar">3,1,2,0,3,1,5,2,7</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Email server backup</td>
                                    <td>
                                        <small class="badge badge-warning">Normal Priority</small>
                                    </td>
                                    <td>
                                        <div class="progress m-b-5">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"> <span class="sr-only">60% Complete</span> </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <span class="sparkbar">-3,1,2,0,3,-1</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="card weather">
                <div class="header">
                    <h2><strong>Weather</strong></h2>
                </div>
                <div class="body">
                    <div class="city">
                        <span>sky is clear</span>
                        <h3>New York</h3>
                        <img src="../assets/images/weather/summer.svg" alt="">
                    </div>
                    <ul class="row days list-unstyled m-b-0">
                        <li>
                            <h5>SUN</h5>
                            <img src="../assets/images/weather/sky.svg" alt="">
                            <span class="degrees">77</span>
                        </li>
                        <li>
                            <h5>MON</h5>
                            <img src="../assets/images/weather/rain.svg" alt="">
                            <span class="degrees">81</span>
                        </li>
                        <li>
                            <h5>TUE</h5>
                            <img src="../assets/images/weather/summer.svg" alt="">
                            <span class="degrees">82</span>
                        </li>
                        <li>
                            <h5>WED</h5>
                            <img src="../assets/images/weather/summer.svg" alt="">
                            <span class="degrees">82</span>
                        </li>
                        <li>
                            <h5>THU</h5>
                            <img src="../assets/images/weather/cloudy.svg" alt="">
                            <span class="degrees">81</span>
                        </li>
                        <li>
                            <h5>FRI</h5>
                            <img src="../assets/images/weather/summer.svg" alt="">
                            <span class="degrees">67</span>
                        </li>
                        <li>
                            <h5>SAT</h5>
                            <img src="../assets/images/weather/cloudy.svg" alt="">
                            <span class="degrees">81</span>
                        </li>
                    </ul>						
                </div>
            </div>
            <div class="card bg-dark">
                <div class="body">
                    <h3 class="col-white m-b-0">50.5 Gb</h3>
                    <p class="text-muted">Traffic this month</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                    </div>
                    <small class="col-white">7% higher than last Month</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-6 col-lg-3">
            <div class="card social_widget2">                    
                <div class="body data text-center">
                    <ul class="list-unstyled m-b-0">
                        <li class="m-b-30">
                            <i class="zmdi zmdi-thumb-up col-blue"></i>
                            <h4 class="m-t-0 m-b-0">2,365</h4>
                            <span>Post View</span>
                        </li>
                        <li class="m-b-0">
                            <i class="zmdi zmdi-comment-text col-red"></i>
                            <h4 class="m-t-0 m-b-0">365</h4>
                            <span>Comments</span>
                        </li>
                    </ul>
                </div>
                <div class="name facebook">
                    <ul class="list-unstyled m-b-30">
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">AMERICA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                        <span class="progress-value">50%</span>
                                    </div>
                                </div>
                            </div>                                
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">CANADA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                        <span class="progress-value">15%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">ASIA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
                                        <span class="progress-value">35%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <h5><i class="zmdi zmdi-facebook-box m-r-10"></i> <span>Facebook</span></h5>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card social_widget2">                    
                <div class="body data text-center">
                    <ul class="list-unstyled m-b-0">
                        <li class="m-b-30">
                            <i class="zmdi zmdi-eye col-amber"></i>
                            <h4 class="m-t-0 m-b-0">365</h4>
                            <span>Post View</span>
                        </li>
                        <li class="m-b-0">
                            <i class="zmdi zmdi-comment-text col-red"></i>
                            <h4 class="m-t-0 m-b-0">125</h4>
                            <span>Comments</span>
                        </li>
                    </ul>
                </div>
                <div class="name dribbble">
                    <ul class="list-unstyled m-b-30">
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">AMERICA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                        <span class="progress-value">50%</span>
                                    </div>
                                </div>
                            </div>                                
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">CANADA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                        <span class="progress-value">15%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">ASIA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
                                        <span class="progress-value">35%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <h5><i class="zmdi zmdi-dribbble m-r-10"></i> <span>Dribbble</span></h5>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card social_widget2">                    
                <div class="body data text-center">
                    <ul class="list-unstyled m-b-0">
                        <li class="m-b-30">
                            <i class="zmdi zmdi-thumb-up col-blue"></i>
                            <h4 class="m-t-0 m-b-0">3,159</h4>
                            <span>Like</span>
                        </li>
                        <li class="m-b-0">
                            <i class="zmdi zmdi-comment-text col-red"></i>
                            <h4 class="m-t-0 m-b-0">462</h4>
                            <span>Twitt</span>
                        </li>
                    </ul>
                </div>
                <div class="name twitter">
                    <ul class="list-unstyled m-b-30">
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">AMERICA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                        <span class="progress-value">50%</span>
                                    </div>
                                </div>
                            </div>                                
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">CANADA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                        <span class="progress-value">15%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">ASIA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
                                        <span class="progress-value">35%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <h5><i class="zmdi zmdi-twitter-box m-r-10"></i> <span>Twitter</span></h5>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card social_widget2">                    
                <div class="body data text-center">
                    <ul class="list-unstyled m-b-0">
                        <li class="m-b-30">
                            <i class="zmdi zmdi-eye col-amber"></i>
                            <h4 class="m-t-0 m-b-0">5,192,776</h4>
                            <span>Views</span>
                        </li>
                        <li class="m-b-0">
                            <i class="zmdi zmdi-youtube-play col-red"></i>
                            <h4 class="m-t-0 m-b-0">10K</h4>
                            <span>Subscribe</span>
                        </li>
                    </ul>
                </div>
                <div class="name youtube">
                    <ul class="list-unstyled m-b-30">
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">AMERICA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                        <span class="progress-value">50%</span>
                                    </div>
                                </div>
                            </div>                                
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">CANADA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%;">
                                        <span class="progress-value">15%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-25">
                            <div class="progress-container">
                                <span class="progress-badge">ASIA</span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width: 35%;">
                                        <span class="progress-value">35%</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <h5><i class="zmdi zmdi-youtube m-r-10"></i> <span>YouTube</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 col-lg-5">
            <div class="card">
                <div class="header">
                    <h2><strong>Chat</strong> Box<small>Design Team</small></h2>                       
                </div>
                <div class="body">
                    <div class="cwidget-scroll">
                        <ul class="chat-widget m-r-5 clearfix">
                            <li class="left float-left">
                                <img src="../assets/images/xs/avatar3.jpg" class="rounded-circle" alt="">
                                <div class="chat-info">
                                    <a class="name" href="javascript:void(0);">Alexander</a>
                                    <span class="datetime">6:12</span>                            
                                    <span class="message">Hello, John </span>
                                </div>
                            </li>
                            <li class="right">
                                <div class="chat-info"><span class="datetime">6:15</span> <span class="message">Hi, Alexander<br> How are you!</span> </div>
                            </li>
                            <li class="right">
                                <div class="chat-info"><span class="datetime">6:16</span> <span class="message">There are many variations of passages of Lorem Ipsum available</span> </div>
                            </li>
                            <li class="left float-left"> <img src="../assets/images/xs/avatar2.jpg" class="rounded-circle" alt="">
                                <div class="chat-info"> <a class="name" href="javascript:void(0);">Elizabeth</a> <span class="datetime">6:25</span> <span class="message">Hi, Alexander,<br> John <br> What are you doing?</span> </div>
                            </li>
                            <li class="left float-left"> <img src="../assets/images/xs/avatar1.jpg" class="rounded-circle" alt="">
                                <div class="chat-info"> <a class="name" href="javascript:void(0);">Michael</a> <span class="datetime">6:28</span> <span class="message">I would love to join the team.</span> </div>
                            </li>
                                <li class="right">
                                <div class="chat-info"><span class="datetime">7:02</span> <span class="message">Hello, <br>Michael</span> </div>
                            </li>
                        </ul>
                    </div>
                    <div class="input-group p-t-15">
                        <input type="text" class="form-control" placeholder="Enter text here...">
                        <span class="input-group-addon">
                            <i class="zmdi zmdi-mail-send"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-7">
            <div class="card">
                <div class="header">
                    <h2><strong>Data</strong> Managed <small>Description text here...</small></h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-md-6">
                            <p>External Records</p>
                            <h2>1,523</h2>
                        </div>
                        <div class="col-md-6">
                            <div class="sparkline" data-type="bar" data-width="97%" data-height="60px" data-bar-Width="4" data-bar-Spacing="8" data-bar-Color="#00ced1">2,5,6,4,8,7,5,6,2,3,5,6,2,3,4,2</div>
                        </div>
                    </div>                        
                    <div class="progress m-b-20">
                        <div class="progress-bar progress-bar-success" style="width: 35%"> <span class="sr-only">35% Complete (success)</span> </div>
                        <div class="progress-bar progress-bar-warning progress-bar-striped active" style="width: 20%"> <span class="sr-only">20% Complete (warning)</span> </div>
                        <div class="progress-bar progress-bar-info" style="width: 15%"> <span class="sr-only">15% Complete (danger)</span> </div>
                        <div class="progress-bar progress-bar-danger" style="width: 20%"> <span class="sr-only">20% Complete (warning)</span> </div>
                        <div class="progress-bar l-slategray" style="width: 10%"> <span class="sr-only">10% Complete (danger)</span> </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0">
                            <tbody>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-success"></i></th>
                                    <td>Twitter</td>
                                    <td><span>862 Records</span></td>
                                    <td>35% <i class="zmdi zmdi-trending-up"></i></td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-info"></i></th>
                                    <td>Facebook</td>
                                    <td><span>451 Records</span></td>
                                    <td>15% <i class="zmdi zmdi-trending-up"></i></td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-warning"></i></th>
                                    <td>Mailchimp</td>
                                    <td><span>502 Records</span></td>
                                    <td>20% <i class="zmdi zmdi-trending-down"></i></td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle text-primary"></i></th>
                                    <td>Google</td>
                                    <td><span>502 Records</span></td>
                                    <td>20% <i class="zmdi zmdi-trending-up"></i></td>
                                </tr>
                                <tr>
                                    <th><i class="zmdi zmdi-circle"></i></th>
                                    <td>Other</td>
                                    <td><span>237 Records</span></td>
                                    <td>10% <i class="zmdi zmdi-trending-down"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{secure_asset('assets/js/pages/menu_sm.js')}}"></script>
@stop