<nav class="navbar">
    <ul class="nav navbar-nav navbar-left">
        <li>
            <div class="navbar-header">
            <a href="javascript:void(0);" class="h-bars"></a>
                <a class="navbar-brand" href="{{secure_url('/')}}"><img src="../assets/images/logoFR.png" width="30" alt=""><span class="m-l-10">{{ config('app.name') }}</span></a>
            </div>
        </li>

        <?php if(!auth()->guard()->guest()): ?>
        <!--
        <li class="dropdown app_menu"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-apps"></i></a>
            <ul class="dropdown-menu pullDown">
                <li><a href="{{secure_url('app.mail-inbox')}}"><i class="zmdi zmdi-email m-r-10"></i><span>Mail</span></a></li>
                <li><a href="{{secure_url('app.contact-list')}}"><i class="zmdi zmdi-accounts-list m-r-10"></i><span>Contacts</span></a></li>
                <li><a href="{{secure_url('app.chat')}}"><i class="zmdi zmdi-comment-text m-r-10"></i><span>Chat</span></a></li>
                <li><a href="{{secure_url('pages.invoices')}}"><i class="zmdi zmdi-arrows m-r-10"></i><span>Invoices</span></a></li>
                <li><a href="{{secure_url('app.calendar')}}"><i class="zmdi zmdi-calendar-note m-r-10"></i><span>Calendar</span></a></li>
                <li><a href="javascript:void(0)"><i class="zmdi zmdi-arrows m-r-10"></i><span>Notes</span></a></li>
                <li><a href="javascript:void(0)"><i class="zmdi zmdi-view-column m-r-10"></i><span>Taskboard</span></a></li>                
            </ul>
        </li>
    
        <li class="dropdown notifications hidden-sm-down"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-notifications"></i>
            <span class="label-count">5</span>
            </a>
            <ul class="dropdown-menu pullDown">
                <li class="header">New Message</li>
                <li class="body">
                    <ul class="menu list-unstyled">
                        <li>
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object" src="../assets/images/xs/avatar5.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Alexander <span class="time">13min ago</span></span>
                                        <span class="message">Meeting with Shawn at Stark Tower by 8 o'clock.</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object" src="../assets/images/xs/avatar6.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Grayson <span class="time">22min ago</span></span>
                                        <span class="message">You have 5 unread emails in your inbox.</span>                                        
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object" src="../assets/images/xs/avatar3.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Sophia <span class="time">31min ago</span></span>
                                        <span class="message">OrderPlaced: You received a new oder from Tina.</span>
                                    </div>
                                </div>
                            </a>
                        </li>                
                        <li>
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object" src="../assets/images/xs/avatar4.jpg" alt="">
                                    <div class="media-body">
                                        <span class="name">Isabella <span class="time">35min ago</span></span>
                                        <span class="message">Lara added a comment in Blazing Saddles.</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="footer"> <a href="javascript:void(0);">View All</a> </li>
            </ul>
        </li>
    -->
    <!--
        <li class="dropdown task"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="zmdi zmdi-flag"></i>
            <span class="label-count">3</span>
            </a>
            <ul class="dropdown-menu pullDown">
                <li class="header">Project</li>
                <li class="body">
                    <ul class="menu tasks list-unstyled">
                        <li>
                            <a href="javascript:void(0);">
                                <span class="text-muted">Clockwork Orange <span class="float-right">29%</span></span>
                                <div class="progress">
                                    <div class="progress-bar l-turquoise" role="progressbar" aria-valuenow="29" aria-valuemin="0" aria-valuemax="100" style="width: 29%;"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <span class="text-muted">Blazing Saddles <span class="float-right">78%</span></span>
                                <div class="progress">
                                    <div class="progress-bar l-slategray" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <span class="text-muted">Project Archimedes <span class="float-right">45%</span></span>
                                <div class="progress">
                                    <div class="progress-bar l-parpl" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <span class="text-muted">Eisenhower X <span class="float-right">68%</span></span>
                                <div class="progress">
                                    <div class="progress-bar l-coral" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%;"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <span class="text-muted">Oreo Admin Templates <span class="float-right">21%</span></span>
                                <div class="progress">
                                    <div class="progress-bar l-amber" role="progressbar" aria-valuenow="21" aria-valuemin="0" aria-valuemax="100" style="width: 21%;"></div>
                                </div>
                            </a>
                        </li>                        
                    </ul>
                </li>
                <li class="footer"><a href="javascript:void(0);">View All</a></li>
            </ul>
        </li>       
        <li class="search_bar hidden-sm-down">
            <div class="input-group">                
                <input type="text" class="form-control" placeholder="Search...">
                <span class="input-group-addon">
                    <i class="zmdi zmdi-search"></i>
                </span>
            </div>
        </li>-->
        
        <!--<p class="text-danger">.text-danger</p>-->  
        @if(Auth::user()->admin != 0 || Auth::user()->coordinator != 0 || Auth::user()->parent != 0)
    <li><p  class="text-info font-weight-bold">Active profile: <span class="text-secondary font-weight-bold"> {{Auth::user()->active_profile}}</span></p></li>
        @endif
        <!--
        @if(Auth::user()->admin != 0)
        <li><a href="/profiles/{{Auth::user()->id}}/switchOnAdminProfileById"><button type="button" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-flash"></span>Admin</button></a></li>
        @endif
        @if(Auth::user()->coordinator != 0)
        <li><a href="/profiles/{{Auth::user()->id}}/switchOnCoordinatorProfileById"><button type="button" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-flash"></span>Coordinator</button></a></li>
        @endif
        @if(Auth::user()->parent != 0)
        <li><a href="/profiles/{{Auth::user()->id}}/switchOnParentProfileById"><button type="button" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-flash"></span>Parent</button></a></li>
        @endif
        -->
        @if (Hash::check('userpassword', '$2y$10$GzaqvM/aQESaG3GSew28WOgdp1JdQ62MxlY1nnjXfTqOJSH8BI7Hea')) 
            <li><a  class="text-danger font-weight-bold" href="{{secure_url('apply/apply')}}">Please proceed to update your default password</a></li>
        
        @endif
        <li class="float-right">  
            <!--<a href="javascript:void(0);" class="js-right-chat"><i class="zmdi zmdi-comments"></i></a>-->
            @if($activeRallye != null)
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
