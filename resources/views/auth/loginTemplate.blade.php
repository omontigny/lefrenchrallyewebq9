@extends('layout.authentication')
@section('title', 'Login')
@section('content')
<div class="authentication sidebar-collapse">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-transparent">
        <div class="container">
            <div class="navbar-translate n_logo">
                    <a class="navbar-brand" href="{{secure_url('/')}}" title="">{{ config('app.name') }}</a>
                <button class="navbar-toggler" type="button">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-white btn-round" href="{{route('register')}}">SIGN UP</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="page-header">
        <div class="container">
            <div class="col-md-12 content-center">
                <div class="card-plain">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="header">
                            <div class="logo-container expandUp">
                                <img src="../assets/images/logoFR.png" alt="">
                            </div>
                            <h5>Log in</h5>
                        </div>
                        <div class="content">
                            <div class="input-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" class="form-control" placeholder="Enter User Name" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" class="form-control" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="footer">
                                <button type="submit" class="btn btn-primary btn-round btn-lg btn-block ">
                                        {{ __('SIGN IN') }}
                                    </button>
                            <!--<h5><a href="{{route('authentication.forgot-password')}}" class="link">Forgot Password?</a></h5>-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer class="footer">
          <div class="container">
            <div class="copyright">
              &copy;
              <script>
                document.write(new Date().getFullYear())
              </script>,
              <span> LeFrenchRallye</span>,
              <p class="text-dark text-center">Maintained by <span></span>
              <a class="text-info" >IT'R Consulting</a></p>                </div>
            </div>
          </div>
        </footer>
    </div>
</div>
@stop
