<nav class="navbar">
    <ul class="nav navbar-nav navbar-left">
        <li>
        <div class="navbar-header">
            <a class="navbar-brand" href="{{secure_url('/')}}"><img src="{{secure_asset("../assets/images/logoFR.png")}}" width="30" alt="{{ config('app.name') }}"><span class="m-l-10">{{ config('app.name') }}</span></a>
        </div>
    </li>
    <?php if(!auth()->guard()->guest()): ?>
       
        <li>  
            <a href="{{secure_url('logout')}}" class="mega-menu" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i class="zmdi zmdi-power"></i></a>
            <form id="logout-form" action="{{ secure_url('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>  
        <?php endif; ?>  
        
    </ul>
</nav>