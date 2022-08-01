<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>
    <style>
        *{ margin: 0px; padding: 0px; }
        body{ font-family: Arial, sans-serif;}
        .container{ margin: 0px 20px; padding: 20px; }
        .text-center{ text-align: center; }
        .title{ font-size: 30px; }
        .subtitle{ font-size:20px; color: #aaa; margin-top: 50px; }
    </style>
        @yield('meta')
        {{-- See https://laravel.com/docs/5.7/blade#stacks for usage --}}
        @stack('before-styles')
        <link rel="stylesheet" href="{{ secure_asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
        <!-- +AJO -->
        <link rel="stylesheet" href="{{ secure_asset('assets/css/hm-style.css') }}">
        <!-- _AJO -->
        @stack('after-styles')
        @if (trim($__env->yieldContent('page-styles')))
            @yield('page-styles')
        @endif

        <link rel="stylesheet" href="{{ secure_asset('assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('assets/css/color_skins.css') }}">
        @stack('after-styles')
        @if (trim($__env->yieldContent('page-style')))
            @yield('page-style')
        @endif
</head>
<body>
  <div id="wrapper">
            @include('layout.navbar')
  </div>

  <div class="container">
    <br>
    <br>
    <br>
    <br>
        <h1 class="text-center title">Sorry, We are currently down for maintenance</h1>
         <br>
        <div class="text-center">
            <img src="{{ secure_asset('assets/images/maintenance.jpg') }}" alt="Maintenance Image" class="maintenance-image">
        </div>
        <br>
        <div class="text-center subtitle">We will be up in couple of hours. Thanks for patience</div>
        <!-- You can add your maintenance image here -->
    </div>
    @include('layout.footer')
</body>
</html>
