<aside id="leftsidebar" class="sidebar">
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <div class="image"><a href="{{route('pages.profile')}}"><img src="../assets/images/profile_av.jpg" alt="User"></a></div>
                    <div class="detail">
                        <h4>Michael</h4>
                        <p class="m-b-0">Manager</p>
                        <a href="{{route('app.calendar')}}" title="Events"><i class="zmdi zmdi-calendar"></i></a>
                        <a href="{{route('app.mail-inbox')}}" title="Inbox"><i class="zmdi zmdi-email"></i></a>
                        <a href="{{route('app.contact-list')}}" title="Contact List"><i class="zmdi zmdi-account-box-phone"></i></a>
                        <div class="row">
                            <div class="col-4 p-r-0">
                                <h6 class="m-b-5">852</h6>
                                <small>Sales</small>
                            </div>
                            <div class="col-4 p-l-0 p-r-0">
                                <h6 class="m-b-5">513</h6>
                                <small>Order</small>
                            </div>
                            <div class="col-4 p-l-0">
                                <h6 class="m-b-5">$34M</h6>
                                <small>Revenue</small>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="header">MAIN</li>
            <li class="{{ Request::segment(1) === 'layoutformat' ? 'active open' : null }}">
                <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-gamepad"></i><span>Layouts Format</span></a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('layoutformat/rtl') ? 'active' : null }}"><a href="{{route('layoutformat.rtl')}}">RTL Layouts</a></li>
                    <li class="{{ Request::is('layoutformat/horizontal') ? 'active' : null }}"><a href="{{route('layoutformat.horizontal')}}">Horizontal Menu</a></li>
                    <li class="{{ Request::is('layoutformat/smallmenu') ? 'active' : null }}"><a href="{{route('layoutformat.smallmenu')}}">Small leftmenu</a></li>
                </ul>
            </li>
           
           
        </ul>
    </div>
</aside>