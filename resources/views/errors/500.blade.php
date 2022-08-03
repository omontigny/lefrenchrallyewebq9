@extends('errors::illustrated-layout')

@section('title', __('Page Not Found'))

@section('code', '500')

@section('image')

<div style="background-image: url({{ asset('/assets/images/svg/503.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>

@endsection

@section('message', __("Houston, we've got a problem ! Don't worry contact your administrator"))
