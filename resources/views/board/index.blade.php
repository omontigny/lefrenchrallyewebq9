@extends('layout.master')
@section('title', 'Dashboard')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.min.css')}}"/>
@stop
@section('content')
<div class="container-fluid home">
  <!-- STATS START -->
        <div class="row clearfix">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="body text-center">
                        <h4 class="mt-0">109</h4>
                        <span>Rallyes</span>        
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="body text-center">
                        <h4 class="mt-0">87</h4>
                        <span>Groups</span>          
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="body text-center">
                        <h4 class="mt-0">318</h4>
                        <span>Coordinators</span>          
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="body text-center">
                        <h4 class="mt-0">520</h4>
                        <span>Events</span>
                    </div>
                </div>
            </div>
        </div>
      <!-- STATS END -->
   
  <!-- STATS START -->
  <div class="row clearfix">
      <div class="col-lg-3 col-sm-6">
          <div class="card">
              <div class="body text-center">
                  <h4 class="mt-0">109</h4>
                  <span>Parents</span>        
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-sm-6">
          <div class="card">
              <div class="body text-center">
                  <h4 class="mt-0">87</h4>
                  <span>Children</span>          
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-sm-6">
          <div class="card">
              <div class="body text-center">
                  <h4 class="mt-0">318</h4>
                  <span>Females</span>          
              </div>
          </div>
      </div>
      <div class="col-lg-3 col-sm-6">
          <div class="card">
              <div class="body text-center">
                  <h4 class="mt-0">520</h4>
                  <span>Males</span>
              </div>
          </div>
      </div>
  </div>
<!-- STATS END -->

      <div class="row clearfix">

          <div class="col-lg-4 col-md-12">
              <div class="card">
                  <div class="header">
                      <h2><strong>Browser</strong> Usage</h2>
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
                      <div id="donut_chart" class="dashboard-donut-chart m-b-15"></div>
                      <ul class="os-percentages row">
                          <li class="col-3 ios">
                              <p class="os text-muted">iOS</p>
                              <p class="os-percentage">21<sup>%</sup></p>
                          </li>
                          <li class="col-3 mac">
                              <p class=" os text-muted">Mac</p>
                              <p class="os-percentage">39<sup>%</sup></p>
                          </li>
                          <li class="col-3 linux">
                              <p class="os text-muted">Linux</p>
                              <p class="os-percentage">9<sup>%</sup></p>
                          </li>
                          <li class="col-3 win">
                              <p class="os text-muted">Win</p>
                              <p class="os-percentage">31<sup>%</sup></p>
                          </li>
                      </ul>
                  </div>                    
              </div>                
            </div>
            </div>
      
        <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="header">
                <h2><strong>Browser</strong> Usage</h2>
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
                <div id="donut_chart" class="dashboard-donut-chart m-b-15"></div>
                <ul class="os-percentages row">
                    <li class="col-3 ios">
                        <p class="os text-muted">iOS</p>
                        <p class="os-percentage">21<sup>%</sup></p>
                    </li>
                    <li class="col-3 mac">
                        <p class=" os text-muted">Mac</p>
                        <p class="os-percentage">39<sup>%</sup></p>
                    </li>
                    <li class="col-3 linux">
                        <p class="os text-muted">Linux</p>
                        <p class="os-percentage">9<sup>%</sup></p>
                    </li>
                    <li class="col-3 win">
                        <p class="os text-muted">Win</p>
                        <p class="os-percentage">31<sup>%</sup></p>
                    </li>
                </ul>
            </div>                    
        </div>                
      </div>
      </div>
      </div>


    <div class="row clearfix">
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="1600" data-speed="2000" data-fresh-interval="700">1600 <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <p class="text-muted">New Feedbacks</p>
                    <div class="progress">
                        <div class="progress-bar l-blush" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                    </div>
                    <small>Change 15%</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0">50.5 Gb <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <p class="text-muted">Traffic this month</p>
                    <div class="progress">
                        <div class="progress-bar l-turquoise" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                    </div>
                    <small>Change 5%</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="2105" data-speed="2000" data-fresh-interval="700">2105 <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <p class="text-muted">Pageviews</p>
                    <div class="progress">
                        <div class="progress-bar l-blue" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                    </div>
                    <small>Change 23%</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="2105" data-speed="2000" data-fresh-interval="700">2105 <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <p class="text-muted">Visitors</p>
                    <div class="progress">
                        <div class="progress-bar l-parpl" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                    </div>
                    <small>Change 12%</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card bg-dark">
                <div class="header">
                    <h2><strong>Sales</strong> Report</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right float-right">
                                <li><a href="javascript:void(0);">Edit</a></li>
                                <li><a href="javascript:void(0);">Delete</a></li>
                                <li><a href="javascript:void(0);">Report</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs padding-0">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#chart-view">Chart View</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#table-view">Table View</a></li>
                    </ul>
                        
                    <!-- Tab panes -->
                    <div class="tab-content m-t-10">
                        <div class="tab-pane active" id="chart-view">
                            <div id="area_chart" class="graph m-b-20"></div>
                            <div class="row text-center">
                                <div class="col-sm-3 col-6">
                                    <h4 class="margin-0 col-white">$113 <i class="zmdi zmdi-trending-up col-green"></i></h4>
                                    <p class="text-muted m-b-0"> Today's Sales</p>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <h4 class="margin-0 col-white">$814 <i class="zmdi zmdi-trending-down col-red"></i></h4>
                                    <p class="text-muted m-b-0">This Week's Sales</p>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <h4 class="margin-0 col-white">$3251 <i class="zmdi zmdi-trending-up col-green"></i></h4>
                                    <p class="text-muted m-b-0">This Month's Sales</p>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <h4 class="margin-0 col-white">$51,254 <i class="zmdi zmdi-trending-up col-green"></i></h4>
                                    <p class="text-muted m-b-0">This Year's Sales</p>
                                </div>
                            </div>                                
                        </div>
                        <div class="tab-pane" id="table-view">
                            <div class="table-responsive">
                                <table class="table m-b-5 table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">#</th>
                                            <th>Name</th>
                                            <th>Item</th>
                                            <th class="hidden-sm-down">Address</th>
                                            <th>Quantity</th>                                    
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                            <td>Hossein</td>
                                            <td>IPONE-7</td>
                                            <td class="hidden-sm-down">Porterfield 508 Virginia Street Chicago, IL 60653</td>
                                            <td>3</td>
                                            <td><span class="badge badge-warning">PENDING</span></td>
                                        </tr>
                                        <tr>
                                            <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                            <td>Camara</td>
                                            <td>NOKIA-8</td>
                                            <td class="hidden-sm-down">2595 Pearlman Avenue Sudbury, MA 01776 </td>
                                            <td>3</td>
                                            <td><span class="badge badge-warning">PENDING</span></td>
                                        </tr>
                                        <tr>
                                            <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                            <td>Maryam</td>
                                            <td>NOKIA-456</td>
                                            <td class="hidden-sm-down">Porterfield 508 Virginia Street Chicago, IL 60653</td>
                                            <td>4</td>
                                            <td><span class="badge badge-success">DONE</span></td>
                                        </tr>
                                        <tr>
                                            <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                            <td>Micheal</td>
                                            <td>SAMSANG PRO</td>
                                            <td class="hidden-sm-down">508 Virginia Street Chicago, IL 60653</td>
                                            <td>1</td>
                                            <td><span class="badge badge-success">DONE</span></td>
                                        </tr>
                                        <tr>
                                            <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                            <td>Frank</td>
                                            <td>NOKIA-456</td>
                                            <td class="hidden-sm-down">1516 Holt Street West Palm Beach, FL 33401</td>
                                            <td>13</td>
                                            <td><span class="badge badge-warning">PENDING</span></td>
                                        </tr>
                                        <tr>
                                            <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                            <td>Micheal</td>
                                            <td>SAMSANG PRO</td>
                                            <td class="hidden-sm-down">508 Virginia Street Chicago, IL 60653</td>
                                            <td>1</td>
                                            <td><span class="badge badge-success">DONE</span></td>
                                        </tr>
                                        <tr>
                                            <td><img src="http://via.placeholder.com/60x40" alt="Product img"></td>
                                            <td>Micheal</td>
                                            <td>SAMSANG PRO</td>
                                            <td class="hidden-sm-down">508 Virginia Street Chicago, IL 60653</td>
                                            <td>1</td>
                                            <td><span class="badge badge-success">DONE</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-3 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Total</strong> Revenue</h2>                        
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">2017 Year</a></li>
                                <li><a href="javascript:void(0);">2016 Year</a></li>
                                <li><a href="javascript:void(0);">2015 Year</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body text-center">
                    <h4 class="margin-0">Total Sale</h4>
                    <h6 class="m-b-20">2,45,124</h6>
                    <input type="text" class="knob" value="35" data-width="110" data-height="110" data-thickness="0.25" data-angleArc="250" data-angleoffset="-125" data-fgColor="#212121" readonly>
                    <small class="displayblock">47% Average <i class="zmdi zmdi-trending-up"></i></small>
                    <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#7460ee">2,5,6,3,4,5,6,9,8,7,4,5,6,2,1</div>
                    <h6 class="m-t-15 p-b-15">Weekly Earnings</h6>
                    <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="2" data-bar-Spacing="7" data-bar-Color="#11a0f8">3,1,5,4,7,8,2,3,1,4,6,5,4,4,2</div>
                    <h6 class="m-t-15">Monthly Earnings</h6>
                </div>
            </div>                
        </div>
        <div class="col-lg-5 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Total</strong> Earnings</h2>                        
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">2017 Year</a></li>
                                <li><a href="javascript:void(0);">2016 Year</a></li>
                                <li><a href="javascript:void(0);">2015 Year</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">                        
                    <button class="btn btn-primary btn-round btn-sm">Week</button>
                    <button class="btn btn-primary btn-round btn-sm">Month</button>
                    <button class="btn btn-primary btn-round btn-sm">Year</button>
                    <div id="m_area_chart" style="height: 323px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Browser</strong> Usage</h2>
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
                    <div id="donut_chart" class="dashboard-donut-chart m-b-15"></div>
                    <ul class="os-percentages row">
                        <li class="col-3 ios">
                            <p class="os text-muted">iOS</p>
                            <p class="os-percentage">21<sup>%</sup></p>
                        </li>
                        <li class="col-3 mac">
                            <p class=" os text-muted">Mac</p>
                            <p class="os-percentage">39<sup>%</sup></p>
                        </li>
                        <li class="col-3 linux">
                            <p class="os text-muted">Linux</p>
                            <p class="os-percentage">9<sup>%</sup></p>
                        </li>
                        <li class="col-3 win">
                            <p class="os text-muted">Win</p>
                            <p class="os-percentage">31<sup>%</sup></p>
                        </li>
                    </ul>
                </div>                    
            </div>                
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 col-lg-8">
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
                            <div class="sparkline m-b-20" data-type="bar" data-width="97%" data-height="60px" data-bar-Width="4" data-bar-Spacing="8" data-bar-Color="#00ced1">2,5,6,4,8,7,5,6,2,3,5,6,2,3,4,2</div>
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
                                    <th><i class="zmdi zmdi-circle text-danger"></i></th>
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
        <div class="col-md-12 col-lg-4">
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
                                    <span class="datetime">11:12</span>                            
                                    <span class="message">Hello, Michael<br>What is the update on Eisenhower X?</span>
                                </div>
                            </li>
                            <li class="right">
                                <div class="chat-info"><span class="datetime">11:15</span> <span class="message">Hi, Alexander<br> It is almost completed. I will send you an email later today.</span> </div>
                            </li>
                            <li class="left float-left">
                                <img src="../assets/images/xs/avatar3.jpg" class="rounded-circle" alt="">
                                <div class="chat-info">
                                    <a class="name" href="javascript:void(0);">Alexander</a>
                                    <span class="datetime">11:22</span>                            
                                    <span class="message">That's great. Will catch you in evening.</span>
                                </div>
                            </li>
                            <li class="right">
                                <div class="chat-info"><span class="datetime">11:25</span> <span class="message">Sure we'will have a blast today.</span> </div>
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
    </div>                
    <div class="row clearfix text-center">
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <input type="text" class="knob" value="13" data-width="90" data-height="90" data-thickness="0.1" data-fgColor="#72c2ff" readonly>
                    <span class="displayblock m-t-15">Email Bounced</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <input type="text" class="knob" value="45" data-width="90" data-height="90" data-thickness="0.1" data-fgColor="#a890d3" readonly>
                    <span class="displayblock m-t-15">Email Opened</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <input type="text" class="knob" value="37" data-width="90" data-height="90" data-thickness="0.1" data-fgColor="#708090" readonly>
                    <span class="displayblock m-t-15">Storage Remaining</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card">
                <div class="body">
                    <input type="text" class="knob" value="68" data-width="90" data-height="90" data-thickness="0.1" data-fgColor="#49c5b6" readonly>
                    <span class="displayblock m-t-15">Page Views</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 col-lg-8">
            <div class="card user-account">
                <div class="header">
                    <h2><strong>User</strong> Accounts <small>Description text here...</small></h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right float-right">
                                <li><a href="javascript:void(0);">Edit</a></li>
                                <li><a href="javascript:void(0);">Delete</a></li>
                                <li><a href="javascript:void(0);">Report</a></li>
                            </ul>
                        </li>
                        <li class="remove">
                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Profile</th>
                                    <th>User ID</th>
                                    <th class="hidden-xs">Email Address</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><div class="media-object"><img src="../assets/images/xs/avatar1.jpg" alt="" class="rounded-circle"></div></td>
                                    <td>jacob</td>
                                    <td class="hidden-xs">jacob@gnail.com</td>
                                    <td><span class="badge badge-success">Approved</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><div class="media-object"><img src="../assets/images/xs/avatar2.jpg" alt="" class="rounded-circle"></div></td>
                                    <td>charlotte</td>
                                    <td class="hidden-xs">a.charlotte@gnail.com</td>
                                    <td><span class="badge badge-warning">Suspended</span></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><div class="media-object"><img src="../assets/images/xs/avatar3.jpg" alt="" class="rounded-circle"></div></td>
                                    <td>grayson</td>
                                    <td class="hidden-xs">grayson@yahoo.com</td>
                                    <td><span class="badge badge-danger">Blocked</span></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><div class="media-object"><img src="../assets/images/xs/avatar4.jpg" alt="" class="rounded-circle"></div></td>
                                    <td>jacob</td>
                                    <td class="hidden-xs">jacob@gnail.com</td>
                                    <td><span class="badge badge-success">Approved</span></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><div class="media-object"><img src="../assets/images/xs/avatar5.jpg" alt="" class="rounded-circle"></div></td>
                                    <td>amelia</td>
                                    <td class="hidden-xs">amelia@gnail.com</td>
                                    <td><span class="badge badge-success">Approved</span></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td><div class="media-object"><img src="../assets/images/xs/avatar6.jpg" alt="" class="rounded-circle"></div></td>
                                    <td>michael</td>
                                    <td class="hidden-xs">michael@gmail.com</td>
                                    <td><span class="badge badge-info">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td><div class="media-object "><img src="../assets/images/xs/avatar7.jpg" alt="" class="rounded-circle"></div></td>
                                    <td>michael</td>
                                    <td class="hidden-xs">michael@gmail.com</td>
                                    <td><span class="badge badge-info">Pending</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="card visitors-map">
                <div class="header">
                    <h2><strong>Visitors</strong> Statistics</h2>
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
                    <div id="world-map-markers" style="height: 280px;" class="m-b-10"></div>
                    <div class="table-responsive">
                        <table class="table table-hover m-b-0">
                            <tbody>
                                <tr>                                            
                                    <td>
                                        <small>Page Views</small>
                                        <h5 class="m-b-0">32,211,536</h5>
                                    </td>
                                    <td>
                                        <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="4" data-bar-Spacing="7" data-bar-Color="#11a0f8">2,3,5,6,9,8,7,8,7,4,6,5</div>
                                    </td>
                                </tr>
                                <tr>                                            
                                    <td>
                                        <small>Site Visitors</small>
                                        <h5 class="m-b-0">23,516</h5>
                                    </td>
                                    <td>
                                        <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="4" data-bar-Spacing="7" data-bar-Color="#11a0f8">8,5,3,2,2,3,5,6,4,5,7,5</div>
                                    </td>
                                </tr>
                                <tr>                                            
                                    <td>
                                        <small>Total Clicks</small>
                                        <h5 class="m-b-0">4,536</h5>
                                    </td>
                                    <td>
                                        <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="4" data-bar-Spacing="7" data-bar-Color="#11a0f8">6,5,4,6,5,5,2,3,1,8,4,2</div>
                                    </td>
                                </tr>
                                <tr>                                            
                                    <td>
                                        <small>Total Returns</small>
                                        <h5 class="m-b-0">516</h5>
                                    </td>
                                    <td>
                                        <div class="sparkline m-t-10" data-type="bar" data-width="97%" data-height="26px" data-bar-Width="4" data-bar-Spacing="7" data-bar-Color="#11a0f8">8,5,3,2,2,3,5,6,4,5,7,5</div>
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
        <div class="col-lg-4 col-md-12">
            <div class="card">
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
                    <ul class="list-unstyled feeds_widget">
                        <li>
                            <div class="feeds-left"><i class="zmdi zmdi-thumb-up"></i></div>
                            <div class="feeds-body">
                                <h4 class="title">7 New Feedback <small class="float-right text-muted">Today</small></h4>
                                <small>It will give a smart finishing to your site</small>
                            </div>
                        </li>
                        <li>
                            <div class="feeds-left"><i class="zmdi zmdi-account-circle"></i></div>
                            <div class="feeds-body">
                                <h4 class="title">New User <small class="float-right text-muted">10:45</small></h4>
                                <small>I feel great! Thanks team</small>
                            </div>
                        </li>
                        <li>
                            <div class="feeds-left"><i class="zmdi zmdi-help"></i></div>
                            <div class="feeds-body">
                                <h4 class="title text-warning">Server Warning <small class="float-right text-muted">10:50</small></h4>
                                <small>Your connection is not private</small>
                            </div>
                        </li>
                        <li>
                            <div class="feeds-left"><i class="zmdi zmdi-check"></i></div>
                            <div class="feeds-body">
                                <h4 class="title text-danger">Issue Fixed <small class="float-right text-muted">11:05</small></h4>
                                <small>WE have fix all Design bug with Responsive</small>
                            </div>
                        </li>
                        <li>
                            <div class="feeds-left"><i class="zmdi zmdi-shopping-basket"></i></div>
                            <div class="feeds-body">
                                <h4 class="title">7 New Orders <small class="float-right text-muted">11:35</small></h4>
                                <small>You received a new oder from Tina.</small>
                            </div>
                        </li>                                   
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix social-widget">
        <div class="col-lg-3 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect twitter-widget">
                <div class="icon"><i class="zmdi zmdi-twitter"></i></div>
                <div class="content">
                    <div class="text">Twitt</div>
                    <div class="number">8K</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect instagram-widget">
                <div class="icon"><i class="zmdi zmdi-instagram"></i></div>
                <div class="content">
                    <div class="text">Followers</div>
                    <div class="number">231</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect linkedin-widget">
                <div class="icon"><i class="zmdi zmdi-linkedin"></i></div>
                <div class="content">
                    <div class="text">Followers</div>
                    <div class="number">2510</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect behance-widget">
                <div class="icon"><i class="zmdi zmdi-behance"></i></div>
                <div class="content">
                    <div class="text">Project</div>
                    <div class="number">121</div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{secure_asset('assets/bundles/morrisscripts.bundle.js')}}"></script>
<script src="{{secure_asset('assets/bundles/jvectormap.bundle.js')}}"></script>
<script src="{{secure_asset('assets/bundles/knob.bundle.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/index.js')}}"></script>
@stop