<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="description" content="{{ config('app.name') }}">
        <link rel="icon" href="{{ secure_asset('favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
        <title>:: {{ config('app.name') }} :: @yield('title')</title>
        <meta name="description" content="@yield('meta_description', config('app.name'))">
        <meta name="author" content="@yield('meta_author', config('app.name'))">
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
    <?php
        $setting = !empty($_GET['theme']) ? $_GET['theme'] : '';
        $theme = "theme-cyan";
        $menu = "";
        if ($setting == 'p') {
            $theme = "theme-purple";
        } else if ($setting == 'b') {
            $theme = "theme-blue";
        } else if ($setting == 'g') {
            $theme = "theme-green";
        } else if ($setting == 'o') {
            $theme = "theme-orange";
        } else if ($setting == 'bl') {
            $theme = "theme-blush";
        } else {
             $theme = "theme-cyan";
        }
    ?>
    <!-- +AJO -->
            <body class="<?= $theme ?> 'index2'">
    <!-- _AJO -->
        <!-- Page Loader -->
        </div>
        <div id="wrapper">
            @include('layout.navbar')
            <!-- +AJO -->
            @if(Auth::user() != null && Auth::user()->active_profile != null && Auth::user()->active_profile === Config::get('constants.roles.PARENT'))
                @include('layout.hmenuParent')
            @elseif(Auth::user() != null && Auth::user()->active_profile != null && Auth::user()->active_profile === Config::get('constants.roles.COORDINATOR'))
                @include('layout.hmenuCoordinator')
            @else
                @include('layout.hmenu')
            @endif

            <!-- _AJO -->
            <br/>
            <br />
            <section class="content">
        </div>
        <div class="container">
            <br>
            @include('inc.messages')
            @include('inc.metaProfile')
                @yield('content')
        </div>
            </section>
            @if (trim($__env->yieldContent('modal')))
                @yield('modal')
            @endif
        </div>
        <!-- Scripts -->
        @stack('before-scripts')
        <script src="{{ secure_asset('assets/bundles/libscripts.bundle.js') }}"></script>
        <script src="{{ secure_asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
        <script src="{{ secure_asset('assets/bundles/mainscripts.bundle.js') }}"></script>
        @stack('after-scripts')
        @if (trim($__env->yieldContent('page-script')))
            @yield('page-script')
        @endif
        @include('layout.footer')
    </body>
</html>
