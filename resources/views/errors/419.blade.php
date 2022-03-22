@extends('errors::illustrated-layout')

@section('title', __('Page Expired'))
@section('code', '419')
<br>
@if(ENV('APP_DEBUG') == true)
  @section('message', __('Page Expired - '. $exception->getMessage() . '-----' . $exception->getTraceAsString() ))
@else
  @section('message', __('Page Expired' ))
@endif
