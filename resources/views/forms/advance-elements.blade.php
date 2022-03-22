@extends('layout.master')
@section('title', ' Advanced Form Elements')
@section('parentPageTitle', 'Forms')
@section('page-styles')
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/multi-select/css/multi-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/jquery-spinner/css/bootstrap-spinner.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/nouislider/nouislider.min.css')}}">
<link rel="stylesheet" href="{{secure_asset('assets/plugins/select2/select2.css')}}">
@stop
@section('content')
<div class="container-fluid">
    <!-- Color Pickers -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Color</strong> Pickers <small>Taken from <a href="https://github.com/mjolnic/bootstrap-colorpicker/" target="_blank">github.com/mjolnic/bootstrap-colorpicker</a></small> </h2>
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
                    <div class="row clearfix">
                        <div class="col-md-6"> <b>HEX CODE</b>
                            <div class="input-group colorpicker">                                   
                                <input type="text" class="form-control" value="#00AABB">                                    
                                <span class="input-group-addon"> <i></i> </span>
                            </div>
                        </div>
                        <div class="col-md-6"> <b>RGB(A) CODE</b>
                            <div class="input-group colorpicker">                                    
                                <input type="text" class="form-control" value="rgba(0,0,0,0.7)">
                                <span class="input-group-addon"> <i></i> </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Color Pickers --> 
    <!-- Masked Input -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Masked</strong> Input <small>Taken from <a href="https://github.com/RobinHerbots/jquery.inputmask" target="_blank">github.com/RobinHerbots/jquery.inputmask</a></small> </h2>
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
                    <div class="demo-masked-input">
                        <div class="row clearfix">
                            <div class="col-lg-3 col-md-6"> <b>Date</b>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i> </span>
                                    <input type="text" class="form-control date" placeholder="Ex: 30/07/2016">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6"> <b>Time (24 hour)</b>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-time"></i></span>                                        
                                    <input type="text" class="form-control time24" placeholder="Ex: 23:59">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6"> <b>Time (12 hour)</b>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-time"></i></span>
                                    <input type="text" class="form-control time12" placeholder="Ex: 11:59 pm">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6"> <b>Date Time</b>
                                <div class="input-group">
                                    <span class="input-group-addon"> <i class="zmdi zmdi-calendar-note"></i></span>
                                    <input type="text" class="form-control datetime" placeholder="Ex: 30/07/2016 23:59">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6"> <b>Mobile Phone Number</b>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-smartphone"></i></span>
                                    <input type="text" class="form-control mobile-phone-number" placeholder="Ex: +00 (000) 000-00-00">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6"> <b>Phone Number</b>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-phone"></i></span>
                                    <input type="text" class="form-control mobile-phone-number" placeholder="Ex: +00 (000) 000-00-00">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6"> <b>Money (Dollar)</b>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-money"></i></span>
                                    <input type="text" class="form-control money-dollar" placeholder="Ex: 99,99 $">
                                </div>
                            </div>                               
                            <div class="col-lg-3 col-md-6"> <b>IP Address</b>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-laptop"></i></span>
                                    <input type="text" class="form-control ip" placeholder="Ex: 255.255.255.255">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6"> <b>Credit Card</b>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-card"></i></span>
                                    <input type="text" class="form-control credit-card" placeholder="Ex: 0000 0000 0000 0000">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6"> <b>Email Address</b>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                                    <input type="text" class="form-control email" placeholder="Ex: example@example.com">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6"> <b>Serial Key</b>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="zmdi zmdi-key"></i></span>
                                    <input type="text" class="form-control key" placeholder="Ex: XXX0-XXXX-XX00-0XXX">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Masked Input -->        
    <!-- Multi Select -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2> <strong>Multi</strong> Select <small>Taken from <a href="https://github.com/lou/multi-select/" target="_blank">github.com/lou/multi-select</a></small> </h2>
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
                    <select id="optgroup" class="ms" multiple="multiple">
                        <optgroup label="Alaskan/Hawaiian Time Zone">
                        <option value="AK">Alaska</option>
                        <option value="HI">Hawaii</option>
                        </optgroup>
                        <optgroup label="Pacific Time Zone">
                        <option value="CA">California</option>
                        <option value="NV">Nevada</option>
                        <option value="OR">Oregon</option>
                        <option value="WA">Washington</option>
                        </optgroup>
                        <optgroup label="Mountain Time Zone">
                        <option value="AZ">Arizona</option>
                        <option value="CO">Colorado</option>
                        <option value="ID">Idaho</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NM">New Mexico</option>
                        <option value="ND">North Dakota</option>
                        <option value="UT">Utah</option>
                        <option value="WY">Wyoming</option>
                        </optgroup>
                        <optgroup label="Central Time Zone">
                        <option value="AL">Alabama</option>
                        <option value="AR">Arkansas</option>
                        <option value="IL">Illinois</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="OK">Oklahoma</option>
                        <option value="SD">South Dakota</option>
                        <option value="TX">Texas</option>
                        <option value="TN">Tennessee</option>
                        <option value="WI">Wisconsin</option>
                        </optgroup>
                        <optgroup label="Eastern Time Zone">
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="IN">Indiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="OH">Ohio</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WV">West Virginia</option>
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Multi Select -->
    
    <div class="row clearfix"> 
        <!-- Spinners -->
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Spinners</strong> <small>Taken from <a href="https://github.com/vsn4ik/jquery.spinner" target="_blank">github.com/vsn4ik/jquery.spinner</a></small> </h2>
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
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="input-group spinner" data-trigger="spinner">                                    
                                <input type="text" class="form-control text-center" value="1" data-rule="quantity">
                                <span class="input-group-addon"> <a href="javascript:void(0);" class="spin-up" data-spin="up"><i class="zmdi zmdi-caret-up"></i></a> <a href="javascript:void(0);" class="spin-down" data-spin="down"><i class="zmdi zmdi-caret-down"></i></a> </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group spinner" data-trigger="spinner">
                                <input type="text" class="form-control text-center" value="1" data-rule="currency">
                                <span class="input-group-addon"> <a href="javascript:void(0);" class="spin-up" data-spin="up"><i class="zmdi zmdi-caret-up"></i></a> <a href="javascript:void(0);" class="spin-down" data-spin="down"><i class="zmdi zmdi-caret-down"></i></a> </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Spinners --> 
        <!-- Tags Input -->
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Tags</strong> Input <small>Taken from <a href="https://github.com/bootstrap-tagsinput/bootstrap-tagsinput" target="_blank">github.com/bootstrap-tagsinput/bootstrap-tagsinput</a></small> </h2>
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
                    <div class="form-group demo-tagsinput-area">
                        <div class="form-line">
                            <input type="text" class="form-control" data-role="tagsinput" value="Amsterdam,Washington,Sydney,Beijing,Cairo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Tags Input --> 
    </div>
    <!-- Advanced Select2 -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Advanced</strong> Select2 <small>Taken from <a href="http://select2.github.io/select2" target="_blank">select2.github.io/select2</a></small> </h2>
                    <ul class="header-dropdown">
                        <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                            <ul class="dropdown-menu">
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
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-6">
                            <p> <b>Basic</b> </p>
                            <select class="form-control show-tick ms select2" data-placeholder="Select">
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>With OptGroups</b> </p>
                            <select class="form-control show-tick ms select2" data-placeholder="Select">
                                <optgroup label="Picnic">
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                </optgroup>
                                <optgroup label="Camping">
                                <option>Tent</option>
                                <option>Flashlight</option>
                                <option>Toilet Paper</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>Multiple Select</b> </p>
                            <select class="form-control show-tick ms select2" multiple data-placeholder="Select">
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>With Clear Button</b> </p>
                            <select class="form-control show-tick ms search-select" data-placeholder="Select">
                                <option>Hot Dog, Fries and a Soda</option>
                                <option>Burger, Shake and a Smile</option>
                                <option>Sugar, Spice and all things nice</option>
                            </select>
                        </div>
                    </div>
                    <div class="row clearfix m-t-30">
                        <div class="col-lg-3 col-md-6">
                            <p> <b>Max Selection Limit: 2</b> </p>
                            <select id="max-select" class="form-control show-tick ms" multiple>
                                <optgroup label="Condiments" data-max-options="2">
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                </optgroup>
                                <optgroup label="Breads" data-max-options="2">
                                <option>Plain</option>
                                <option>Steamed</option>
                                <option>Toasted</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>Loading Data</b> </p>
                            <input type="hidden" id="loading-select" class="form-control"/>
                            
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>Loading Array Data</b> </p>
                            <input type="hidden" id="array-select" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>Disabled Option</b> </p>
                            <select class="form-control show-tick ms select2" data-placeholder="Select">
                                <option>Mustard</option>
                                <option disabled>Ketchup</option>
                                <option>Relish</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Select2 -->

    <!-- Advanced Select -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Advanced</strong> Select <small>Taken from <a href="https://silviomoreto.github.io/bootstrap-select/" target="_blank">silviomoreto.github.io/bootstrap-select</a></small> </h2>
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
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-6">
                            <p> <b>Basic</b> </p>
                            <select class="form-control show-tick">
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>With OptGroups</b> </p>
                            <select class="form-control show-tick">
                                <optgroup label="Picnic">
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                </optgroup>
                                <optgroup label="Camping">
                                <option>Tent</option>
                                <option>Flashlight</option>
                                <option>Toilet Paper</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>Multiple Select</b> </p>
                            <select class="form-control show-tick" multiple>
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>With Search Bar</b> </p>
                            <select class="form-control z-index show-tick" data-live-search="true">
                                <option>Hot Dog, Fries and a Soda</option>
                                <option>Burger, Shake and a Smile</option>
                                <option>Sugar, Spice and all things nice</option>
                            </select>
                        </div>
                    </div>
                    <div class="row clearfix m-t-30">
                        <div class="col-lg-3 col-md-6">
                            <p> <b>Max Selection Limit: 2</b> </p>
                            <select class="form-control show-tick" multiple>
                                <optgroup label="Condiments" data-max-options="2">
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                </optgroup>
                                <optgroup label="Breads" data-max-options="2">
                                <option>Plain</option>
                                <option>Steamed</option>
                                <option>Toasted</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>Display Count</b> </p>
                            <select class="form-control show-tick" multiple data-selected-text-format="count">
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                                <option>Onions</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>With SubText</b> </p>
                            <select class="form-control show-tick" data-show-subtext="true">
                                <option data-subtext="French's">Mustard</option>
                                <option data-subtext="Heinz">Ketchup</option>
                                <option data-subtext="Sweet">Relish</option>
                                <option data-subtext="Miracle Whip">Mayonnaise</option>
                                <option data-divider="true"></option>
                                <option data-subtext="Honey">Barbecue Sauce</option>
                                <option data-subtext="Ranch">Salad Dressing</option>
                                <option data-subtext="Sweet &amp; Spicy">Tabasco</option>
                                <option data-subtext="Chunky">Salsa</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <p> <b>Disabled Option</b> </p>
                            <select class="form-control show-tick">
                                <option>Mustard</option>
                                <option disabled>Ketchup</option>
                                <option>Relish</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Advanced Select --> 
    <!-- Input Slider -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2> <strong>Input</strong> Slider <small>Taken from <a href="http://refreshless.com/nouislider" target="_blank">refreshless.com/nouislider</a> & <a href="http://materializecss.com" target="_blank">materializecss.com</a></small> </h2>
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
                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-12">
                            <p><b>Basic Example</b></p>
                            <div id="nouislider_basic_example"></div>
                            <div class="m-t-20 font-12"><b>Value: </b><span class="js-nouislider-value"></span></div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p><b>Range Example</b></p>
                            <div id="nouislider_range_example"></div>
                            <div class="m-t-20 font-12"><b>Value: </b><span class="js-nouislider-value"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Input Slider --> 
</div>
@stop
@section('page-script')
<script src="{{secure_asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
<script src="{{secure_asset('assets/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{secure_asset('assets/plugins/jquery-spinner/js/jquery.spinner.js')}}"></script>
<script src="{{secure_asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<script src="{{secure_asset('assets/plugins/nouislider/nouislider.js')}}"></script>
<script src="{{secure_asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{secure_asset('assets/js/pages/forms/advanced-form-elements.js')}}"></script>
@stop