<div class="menu-container">
    <div class="menu">
        <!-- +AJO -->
        <ul class="pullDown">
            <li><a href="javascript:void(0)">Admin</a>
                <ul class="pullDown">
                    <li><a href="{{secure_url('roles')}}">Roles</a></li>
                    <li><a href="{{secure_url('admin/controlpanel')}}">Control Panel</a></li>
                    <li><a href="{{secure_url('schools')}}">Schools</a></li>
                    <li><a href="{{secure_url('schoolyears')}}">School Years</a></li>
                    <!--<li><a href="{{secure_url('admin/contacts')}}">Contacts</a></li>-->
                    <li><a href="{{secure_url('admin/choosemembers')}}">Choose Members</a></li>
                    <li><a href="{{secure_url('admin/payments')}}">Payments</a></li>
                    <li><a href="{{secure_url('admin/eventgroups')}}">Event Groups</a></li>
                    <li><a href="{{secure_url('admin/acceptanceemails')}}">Acceptance Emails</a></li>
                </ul>
            </li>
            <li><a href="{{secure_url('rallyes')}}">Rallyes</a> 
                <ul class="pullDown">
                    <li><a href="{{secure_url('groups')}}">Groups</a></li>
                </ul>
            </li>
            <li><a href="{{secure_url('calendars')}}">Calendar</a>
            </li>
            <!-- _AJO -->
            <li><a href="{{route('welcome')}}">Dashboard</a></li>
            <li><a href="javascript:void(0)">Layouts</a>
                <ul class="pullDown">                    
                    <li class="{{ Request::is('layoutformat/rtl') ? 'active' : null }}"><a href="{{route('layoutformat.rtl')}}">RTL Layouts</a></li>
                    <li class="{{ Request::is('layoutformat/horizontal') ? 'active' : null }}"><a href="{{route('layoutformat.horizontal')}}">Horizontal Menu</a></li>
                    <li class="{{ Request::is('layoutformat/smallmenu') ? 'active' : null }}"><a href="{{route('layoutformat.smallmenu')}}">Small leftmenu</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0)">App</a>
                <ul class="pullDown">                                   
                    <li class="{{ Request::is('app/mail-compose') ? 'active' : null }}"><a href="{{route('app.mail-compose')}}">Mail Compose</a></li>
                    <li class="{{ Request::is('app/mail-inbox') ? 'active' : null }}"><a href="{{route('app.mail-inbox')}}">Mail Inbox</a></li>
                    <li class="{{ Request::is('app/chat') ? 'active' : null }}"><a href="{{route('app.chat')}}">Chat</a></li>
                    <li class="{{ Request::is('app/calendar') ? 'active' : null }}"><a href="{{route('app.calendar')}}">Calendar</a></li>
                    <li class="{{ Request::is('app/contact-list') ? 'active' : null }}"><a href="{{route('app.contact-list')}}">Contact list</a></li>
                    <li class="{{ Request::is('app/taskboard') ? 'active' : null }}"><a href="{{route('app.taskboard')}}">TaskBoard</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0)">UI Kit</a>
                <ul class="pullDown">
                    <li><span><i class="zmdi zmdi-label"></i> List</span>
                        <ul>
                            <li class="{{ Request::is('ui-elements/ui-kit') ? 'active' : null }}"><a href="{{route('ui-elements.ui-kit')}}">UI Kit</a></li>
                            <li class="{{ Request::is('ui-elements/alerts') ? 'active' : null }}"><a href="{{route('ui-elements.alerts')}}">Alerts</a></li>
                            <li class="{{ Request::is('ui-elements/collapse') ? 'active' : null }}"><a href="{{route('ui-elements.collapse')}}">Collapse</a></li>
                            <li class="{{ Request::is('ui-elements/colors') ? 'active' : null }}"><a href="{{route('ui-elements.colors')}}">Colors</a></li>
                        </ul>
                    </li>
                    <li><span><i class="zmdi zmdi-label"></i> List</span>
                        <ul>
                            <li class="{{ Request::is('ui-elements/dialogs') ? 'active' : null }}"><a href="{{route('ui-elements.dialogs')}}">Dialogs</a></li>
                            <li class="{{ Request::is('ui-elements/icons') ? 'active' : null }}"><a href="{{route('ui-elements.icons')}}">Icons</a></li>
                            <li class="{{ Request::is('ui-elements/list-group') ? 'active' : null }}"><a href="{{route('ui-elements.list-group')}}">List Group</a></li>
                            <li class="{{ Request::is('ui-elements/media-object') ? 'active' : null }}"><a href="{{route('ui-elements.media-object')}}">Media Object</a></li>
                        </ul>
                    </li>
                    <li><span><i class="zmdi zmdi-label"></i> List</span>
                        <ul>
                            <li class="{{ Request::is('ui-elements/modals') ? 'active' : null }}"><a href="{{route('ui-elements.modals')}}">Modals</a></li>
                            <li class="{{ Request::is('ui-elements/notifications') ? 'active' : null }}"><a href="{{route('ui-elements.notifications')}}">Notifications</a></li>
                            <li class="{{ Request::is('ui-elements/progress-bars') ? 'active' : null }}"><a href="{{route('ui-elements.progress-bars')}}">Progress Bars</a></li>
                            <li class="{{ Request::is('ui-elements/range-sliders') ? 'active' : null }}"><a href="{{route('ui-elements.range-sliders')}}">Range Sliders</a></li>
                        </ul>
                    </li>
                    <li><span><i class="zmdi zmdi-label"></i> List</span>
                        <ul>
                            <li class="{{ Request::is('ui-elements/nestable') ? 'active' : null }}"><a href="{{route('ui-elements.nestable')}}">Nestable</a></li>
                            <li class="{{ Request::is('ui-elements/tabs') ? 'active' : null }}"><a href="{{route('ui-elements.tabs')}}">Tabs</a></li>
                            <li class="{{ Request::is('ui-elements/waves') ? 'active' : null }}"><a href="{{route('ui-elements.waves')}}">waves</a></li>
                        </ul>
                    </li>                    
                </ul>
            </li>
            <li><a href="javascript:void(0)"><i class="zmdi zmdi-assignment"></i> Forms</a>
                <ul class="pullDown">
                    <li class="{{ Request::is('forms/basic-elements') ? 'active' : null }}"><a href="{{route('forms.basic-elements')}}">Basic Elements</a></li>
                    <li class="{{ Request::is('forms/advance-elements') ? 'active' : null }}"><a href="{{route('forms.advance-elements')}}">Advanced Elements</a></li>
                    <li class="{{ Request::is('forms/examples') ? 'active' : null }}"><a href="{{route('forms.examples')}}">Form Examples</a></li>
                    <li class="{{ Request::is('forms/validation') ? 'active' : null }}"><a href="{{route('forms.validation')}}">Form Validation</a></li>
                    <li class="{{ Request::is('forms/wizard') ? 'active' : null }}"><a href="{{route('forms.wizard')}}">Form Wizard</a></li>
                    <li class="{{ Request::is('forms/editors') ? 'active' : null }}"><a href="{{route('forms.editors')}}">Editor</a></li>
                    <li class="{{ Request::is('forms/dragdrop') ? 'active' : null }}"><a href="{{route('forms.dragdrop')}}">File Upload</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0)">Tables</a>
                <ul class="pullDown">
                    <li class="{{ Request::is('table/normal') ? 'active' : null }}"><a href="{{route('table.normal')}}">Normal Tables</a></li>
                    <li class="{{ Request::is('table/basic') ? 'active' : null }}"><a href="{{route('table.basic')}}">Tables Basic</a></li>
                    <li class="{{ Request::is('table/jquery-datatable') ? 'active' : null }}"><a href="{{route('table.jquery-datatable')}}">Jquery Datatables</a></li>
                    <li class="{{ Request::is('table/editable') ? 'active' : null }}"><a href="{{route('table.editable')}}">Editable Tables</a></li>
                    <li class="{{ Request::is('table/color') ? 'active' : null }}"><a href="{{route('table.color')}}">Tables Color</a></li>
                    <li class="{{ Request::is('table/filter') ? 'active' : null }}"><a href="{{route('table.filter')}}">Table Filter</a></li>
                    <li class="{{ Request::is('table/dragger') ? 'active' : null }}"><a href="{{route('table.dragger')}}">Table dragger</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0)"><i class="zmdi zmdi-chart"></i> Charts</a>
                <ul class="pullDown">
                    <li class="{{ Request::is('charts/morris') ? 'active' : null }}"><a href="{{route('charts.morris')}}">Morris</a> </li>
                    <li class="{{ Request::is('charts/flot') ? 'active' : null }}"><a href="{{route('charts.flot')}}">Flot</a> </li>
                    <li class="{{ Request::is('charts/chartjs') ? 'active' : null }}"><a href="{{route('charts.chartjs')}}">ChartJS</a> </li>
                    <li class="{{ Request::is('charts/sparkline') ? 'active' : null }}"><a href="{{route('charts.sparkline')}}">Sparkline Chart</a></li>
                    <li class="{{ Request::is('charts/jquery-knob') ? 'active' : null }}"><a href="{{route('charts.jquery-knob')}}">Jquery Knob</a> </li>
                    <li class="{{ Request::is('charts/c3') ? 'active' : null }}"><a href="{{route('charts.c3')}}">C3 Charts</a></li>
                </ul>
            </li>            
            <li><a href="javascript:void(0)">Widgets</a>
                <ul class="pullDown">                            
                    <li class="{{ Request::is('widgets/app') ? 'active' : null }}"><a href="{{route('widgets.app')}}">Apps Widgetse</a></li>
                    <li class="{{ Request::is('widgets/data') ? 'active' : null }}"><a href="{{route('widgets.data')}}">Data Widgetse</a></li>
                </ul>
            </li>                       
            <li><a href="javascript:void(0)">Authentication</a>
                <ul class="pullDown">
                    <li><a href="javascript:void(0)">Sign In</a></li>
                    <li><a href="javascript:void(0)">Sign Up</a></li>
                    <li><a href="javascript:void(0)">Forgot Password</a></li>
                    <li><a href="javascript:void(0)">Page 404</a></li>
                    <li><a href="javascript:void(0)">Page 500</a></li>
                    <li><a href="javascript:void(0)">Page Offline</a></li>
                    <li><a href="javascript:void(0)">Locked Screen</a></li>
                </ul>
            </li>            
            <li><a href="javascript:void(0)">Extra </a>
                <ul class="pullDown">
                    <li class="{{ Request::is('pages/blank-page') ? 'active' : null }}"><a href="{{route('pages.blank-page')}}">Blank Page</a></li>
                    <li class="{{ Request::is('pages/image-gallery') ? 'active' : null }}"><a href="{{route('pages.image-gallery')}}">Image Gallery</a></li>
                    <li class="{{ Request::is('pages/profile') ? 'active' : null }}"><a href="{{route('pages.profile')}}">Profile</a></li>
                    <li class="{{ Request::is('pages/timeline') ? 'active' : null }}"><a href="{{route('pages.timeline')}}">Timeline</a></li>
                    <li class="{{ Request::is('pages/pricing') ? 'active' : null }}"><a href="{{route('pages.pricing')}}">Pricing</a></li>
                    <li class="{{ Request::is('pages/invoices') ? 'active' : null }}"><a href="{{route('pages.invoices')}}">Invoices</a></li>
                    <li class="{{ Request::is('pages/search-results') ? 'active' : null }}"><a href="{{route('pages.search-results')}}">Search Results</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>