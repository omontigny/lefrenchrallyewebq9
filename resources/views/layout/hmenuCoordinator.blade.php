    <link rel="stylesheet" href="{{secure_asset('assets/css/hm-style.css')}}" />
<div class="menu-container">
    <div class="menu">
        <ul class="pullDown">
            <?php if(!auth()->guard()->guest()): ?>
            <li><a href="javascript:void(0)">Member</a>
                <ul class="pullDown">
                    <!--<li><a href="{{secure_url('checkin')}}">Invitations</a></li>-->
                    <li><a href="{{secure_url('member/myrallye')}}">My Rallye</a></li>
                    <li><a href="{{secure_url('member/mygroup')}}">My Group (Petit Rallye)</a></li>
                    <li><a href="{{secure_url('member/myeventgroup')}}">My Event Group (All Rallyes)</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0)">Rallyes</a>
                <ul class="pullDown">
                    <li><a href="{{secure_url('rallyeCoordinatorsExtra')}}">Switch my rallye</a></li>
                    <li><a href="{{secure_url('smallgroups')}}">Groups /Event date (Petit Rallye)</a></li>
                    <li><a href="{{secure_url('groups')}}">Event date (Std Rallye)</a></li>
                    <li><a href="{{secure_url('parentGroups')}}">Parent groups (Petit Rallye)</a></li>
                    <li><a href="{{secure_url('parentEvents')}}">Parent Event groups (All Rallyes)</a></li>
                    <li><a href="{{secure_url('waitingList')}}">Waiting list</a></li>
                    <li><a href="{{secure_url('paymentReminderList')}}">PaymentReminder list</a></li>
                </ul>
            </li>
            <!--
            <li><a href="javascript:void(0)">My Event</a>
                <ul class="pullDown">
                    <li><a href="{{secure_url('invitations')}}">Invitation</a></li>
                    <li><a href="{{secure_url('checkin')}}">Guest-list</a></li>
                    <li><a href="{{secure_url('checkinEvent')}}">Check in</a></li>
                </ul>
            </li> -->
            <li><a href="{{secure_url('calendars')}}">Calendar</a>
            </li>
            <li><a href="{{secure_url('apply/apply')}}">Apply</a>
            <li><a href="{{secure_url('applicationrequests')}}">Application requests</a></li>
            <!-- Profile management -->
            <li><a href="javascript:void(0)">Profile</a>
                <ul class="pullDown">
                    @if(Auth::user()->admin != 0)
                    <li><a href="/profiles/{{Auth::user()->id}}/switchOnAdminProfileById">Admin</a></li>
                    @endif
                    @if(Auth::user()->coordinator != 0)
                    <li><a href="/profiles/{{Auth::user()->id}}/switchOnCoordinatorProfileById">Coordinator</a></li>
                    @endif
                    @if(Auth::user()->parent != 0)
                    <li><a href="/profiles/{{Auth::user()->id}}/switchOnParentProfileById">Parent</a></li>
                    @endif
                </ul>
            </li>
            <?php endif; ?>
            <!-- Right Side Of Navbar -->
            <!-- Authentication Links -->
            @guest
            <li class="nav-item float-right">
                <a class="nav-link" href="{{ secure_url('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item  float-right">
                <a class="nav-link" href="{{ secure_url('register') }}">{{ __('Register') }}</a>
            </li>
            @endif
            @else
            <li class="nav-item dropdown  float-right">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right  float-right" aria-labelledby="navbarDropdown">
                    <a class="pullDown" href="{{ secure_url('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ secure_url('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
        </ul>
    </div>
</div>
<!-- For Material Design Colors -->
<div class="modal fade" id="underConstruction" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-pink">
            <div class="modal-header">
                <h4 class="title" id="defaultModalLabel">UNDER CONSTRUCTION</h4>
            </div>
            <div class="modal-body col-white"> This option is under construction, please try it later on!</div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-link waves-effect col-white">SAVE CHANGES</button>-->
                <button type="button" class="btn btn-link waves-effect col-white" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
