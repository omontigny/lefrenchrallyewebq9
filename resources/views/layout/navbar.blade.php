@if(env('APP_ENV') == 'local')
  <nav class="navbar navbar-light" style="background-color: #f8a2a2;">
@elseif(env('APP_ENV') == 'preprod')
  <nav class="navbar navbar-light" style="background-color: #6cb2eb;">
@else
  <nav class="navbar">
@endif
    <ul class="nav navbar-nav navbar-left">
        <div class="navbar-header">
            <li>
                <a href="javascript:void(0);" class="h-bars"></a>
                <a class="navbar-brand" href="{{route('welcome')}}"><img
                        src="{{secure_asset('../assets/images/logoFR.png')}}" width="30"
                        alt="{{ config('app.name') }}"><span class="m-l-10">{{ config('app.name') }}</span></a>

            </li>
        </div>
    </ul>
</nav>
