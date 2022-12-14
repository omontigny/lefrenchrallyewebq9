@extends('errors::illustrated-layout')

@section('title', __('Page Not Found'))

@section('code', '503')

@section('image')

<div style="background-image: url({{ asset('/assets/images/svg/503.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>

@endsection

@section('message', __('Sorry, We are currently down for maintenance. We will be up in couple of hours. Thanks for patience'))
