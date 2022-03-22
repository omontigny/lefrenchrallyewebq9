@extends('layout.master')
@section('title', 'RTL Dashboard')
@section('parentPageTitle', 'Layout Format')
@section('page-style')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/morrisjs/morris.css')}}"/>
<link rel="stylesheet" href="{{secure_asset('assets/css/rtl.css')}}"/>
@stop
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card bg-dark text-center">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="body">
                            <div class="sparkline m-b-20" data-type="bar" data-width="97%" data-height="40px" data-bar-Width="3" data-bar-Spacing="8" data-bar-Color="#999999">2,5,3,7,8,4,2,6,5,4,2,4</div>
                            <h3 class="col-white m-b-0">457 512</h3>
                            <small class="text-muted displayblock">47% Average <i class="zmdi zmdi-trending-up"></i></small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="body">
                            <div class="sparkline m-b-20" data-type="bar" data-width="97%" data-height="40px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#999999">8,5,2,3,5,7,1,5,9,2,4,8</div>
                            <h3 class="col-white m-b-0">236 512</h3>
                            <small class="text-muted displayblock">13% Average <i class="zmdi zmdi-trending-down"></i></small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="body">
                            <div class="sparkline m-b-20" data-type="bar" data-width="97%" data-height="40px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#999999">6,2,4,8,7,5,2,3,6,5,4,8</div>
                            <h3 class="col-white m-b-0">236 512</h3>
                            <small class="text-muted displayblock">47% Average <i class="zmdi zmdi-trending-up"></i></small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="body">
                            <div class="sparkline m-b-20" data-type="bar" data-width="97%" data-height="40px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#999999">4,3,8,7,6,5,2,4,6,5,3,2</div>
                            <h3 class="col-white m-b-0">236 512</h3>
                            <small class="text-muted displayblock">47% Average <i class="zmdi zmdi-trending-up"></i></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2>hello السلام عليكم</h2>
                </div>
                <div class="body">
                    <p>أبجد هوز هو مجرد دمية النص من صناعة الطباعة والتنضيد. وكان أبجد هوز نص الدمية القياسية في هذه الصناعة من أي وقت مضى منذ 1500s، عندما استغرقت طابعة غير معروفة المطبخ من نوع وسارعت لجعل كتاب عينة نوع. وقد نجا ليس فقط خمسة قرون، ولكن أيضا قفزة في التنضيد الإلكترونية، وتبقى دون تغيير أساسا. وقد شاع في 1960s مع الافراج عن أوراق ليتراسيت تحتوي على مقاطع أبجد هوز، ومؤخرا مع برامج النشر المكتبي مثل ألدوس باجيماكر بما في ذلك إصدارات أبجد هوز.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12">
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
            <div class="card">
                <div class="body">
                    <h3 class="m-b-0 number count-to" data-from="0" data-to="2105" data-speed="2000" data-fresh-interval="700">2105 <i class="zmdi zmdi-trending-up float-right"></i></h3>
                    <p class="text-muted">Pageviews</p>
                    <div class="progress">
                        <div class="progress-bar l-parpl" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                    </div>
                    <small>Change 23%</small>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Report <strong>Product</strong> <small>Description text here...</small></h2>
                </div>
                <div class="body">
                    <canvas id="bar_chart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix social-widget">
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect facebook-widget">
                <div class="icon"><i class="zmdi zmdi-facebook"></i></div>
                <div class="content">
                    <div class="text">Like</div>
                    <div class="number">123</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect instagram-widget">
                <div class="icon"><i class="zmdi zmdi-instagram"></i></div>
                <div class="content">
                    <div class="text">Followers</div>
                    <div class="number">231</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect twitter-widget">
                <div class="icon"><i class="zmdi zmdi-twitter"></i></div>
                <div class="content">
                    <div class="text">Followers</div>
                    <div class="number">31</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect google-widget">
                <div class="icon"><i class="zmdi zmdi-google"></i></div>
                <div class="content">
                    <div class="text">Like</div>
                    <div class="number">254</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect linkedin-widget">
                <div class="icon"><i class="zmdi zmdi-linkedin"></i></div>
                <div class="content">
                    <div class="text">Followers</div>
                    <div class="number">2510</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card info-box-2 hover-zoom-effect behance-widget">
                <div class="icon"><i class="zmdi zmdi-behance"></i></div>
                <div class="content">
                    <div class="text">Project</div>
                    <div class="number">121</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-12">
                <div class="card">
                <div class="header">
                    <h2>Media <strong>Social</strong></h2>
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
                    <div class="table-responsive social_media_table">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Media</th>
                                    <th>Name</th>
                                    <th>Like</th>
                                    <th>Comments</th>
                                    <th>Share</th>
                                    <th>Members</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="social_icon linkedin"><i class="zmdi zmdi-linkedin"></i></span>
                                    </td>
                                    <td><span class="list-name">Linked In</span>
                                        <span class="text-muted">Florida, United States</span>
                                    </td>
                                    <td>19K</td>
                                    <td>14K</td>
                                    <td>10K</td>
                                    <td>
                                        <span class="badge badge-success">2341</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="social_icon twitter-table"><i class="zmdi zmdi-twitter"></i></span>
                                    </td>
                                    <td><span class="list-name">Twitter</span>
                                        <span class="text-muted">Arkansas, United States</span>
                                    </td>
                                    <td>7K</td>
                                    <td>11K</td>
                                    <td>21K</td>
                                    <td>
                                        <span class="badge badge-success">952</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="social_icon facebook"><i class="zmdi zmdi-facebook"></i></span>
                                    </td>
                                    <td><span class="list-name">Facebook</span>
                                        <span class="text-muted">Illunois, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>8K</td>
                                    <td>
                                        <span class="badge badge-success">6127</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="social_icon google"><i class="zmdi zmdi-google-plus"></i></span>
                                    </td>
                                    <td><span class="list-name">Google Plus</span>
                                        <span class="text-muted">Arizona, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>154</td>
                                    <td>
                                        <span class="badge badge-success">325</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="social_icon youtube"><i class="zmdi zmdi-youtube-play"></i></span>
                                    </td>
                                    <td><span class="list-name">YouTube</span>
                                        <span class="text-muted">Alaska, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>200</td>
                                    <td>
                                        <span class="badge badge-success">160</span>
                                    </td>
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
<script src="{{secure_asset('assets/plugins/chartjs/Chart.bundle.min.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/rtl.js')}}"></script>
@stop