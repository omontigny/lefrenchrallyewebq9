@extends('errors::illustrated-layout')

@section('title', __('Page Expired'))

@section('code', '419')

@section('image')

@if(ENV('APP_DEBUG') == true)

  @section('message', __('Page Expired - '. $exception->getMessage() . '-----' . $exception->getTraceAsString() ))
@else
  <div style="background-image: url({{ asset('/assets/images/svg/419.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>

  @endsection
  @section('message', __('Sorry, your session has expired. Please refresh and try again.'))
@endif
