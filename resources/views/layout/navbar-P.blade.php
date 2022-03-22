
        <ul class="nav navbar-nav navbar-left">
            <li>
                <div class="navbar-header">
                    <!-- -AJO -->
                    <!--
                    @if (Request::segment(2) === 'horizontal')
                        <a href="javascript:void(0);" class="h-bars"></a>
                    @else
                        <a href="javascript:void(0);" class="bars"></a>
                    @endif
                    -->
                    <a href="javascript:void(0);" class="h-bars"></a>
                    <!-- _AJO -->
                    <a class="navbar-brand" href="{{secure_url('/')}}"><img src="../assets/images/logoFR.png" width="30" alt="{{ config('app.name') }}"><span class="m-l-10">{{ config('app.name') }}</span></a>
                </div>
            </li>

        <?php if(!auth()->guard()->guest()): ?>

        <li class="float-right">
            @if($activeRallye != null)
            @if(Auth::user()->admin != 0 || Auth::user()->coordinator != 0 || Auth::user()->parent != 0)
            <span  class="text-info font-weight-bold">Active profile:</span><span class="text-secondary font-weight-bold"> {{Auth::user()->active_profile}}</span>
            @endif

            <a href="javascript:void(0);" class="js-right-chat">ACTIVE RALLYE: <b><span class="text-danger">{{$activeRallye}}</span></b></i></a>
            @endif

            <a href="javascript:void(0);" class="js-right-sidebar"><i class="zmdi zmdi-settings"></i></a>
            <a href="javascript:void(0);" class="btn_overlay hidden-sm-down"><i class="zmdi zmdi-sort-amount-desc"></i></a>
            <a href="{{secure_url('logout')}}" class="mega-menu" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i class="zmdi zmdi-power"></i></a>
            <form id="logout-form" action="{{ secure_url('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
        <?php endif; ?>
    </ul>
</nav>
