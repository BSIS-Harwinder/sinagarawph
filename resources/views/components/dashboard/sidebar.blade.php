@if($is_client)
    <div class="left-side-menu">
        <div class="slimscroll-menu">
            <div id="sidebar-menu">
                <ul class="metismenu" id="side-menu">
                    <li class="menu-title">Navigation</li>
                    <li>
                        <a href="{{ route('client.dashboard') }}">
                            <i class="fe-airplay"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('client.orders') }}">
                            <i class="mdi mdi-book"></i>
                            <span> My Site Visits </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@else
    @if($user_level == 1)
        <div class="left-side-menu">
            <div class="slimscroll-menu">
                <div id="sidebar-menu">
                    <ul class="metismenu" id="side-menu">
                        <li class="menu-title">Navigation</li>
                        <li>
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fe-airplay"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('offers.index') }}">
                                <i class="fa fa-solar-panel"></i>
                                <span> Offers </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('schedules.index') }}">
                                <i class="bi bi-calendar-week"></i>
                                <span> Schedules </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('clients.index') }}">
                                <i class="bi bi-person-lines-fill"></i>
                                <span> Clients </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('engineers.index') }}">
                                <i class="bi bi-person-vcard-fill"></i>
                                <span> Employees </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contracts.index') }}">
                                <i class="mdi mdi-folder-account"></i>
                                <span> Contracts </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('invoices.index') }}">
                                <i class="mdi mdi-cash-refund"></i>
                                <span> Invoices </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('audit.index') }}">
                                <i class="mdi mdi-chart-line-variant"></i>
                                <span> Logs </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    @elseif($user_level == 2)
        <div class="left-side-menu">
            <div class="slimscroll-menu">
                <div id="sidebar-menu">
                    <ul class="metismenu" id="side-menu">
                        <li class="menu-title">Navigation</li>
                        <li>
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fe-airplay"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('engineer_schedule') }}">
                                <i class="bi bi-person-vcard-fill"></i>
                                <span> Schedules </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('clients.index') }}">
                                <i class="bi bi-person-lines-fill"></i>
                                <span> Clients </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contracts.index') }}">
                                <i class="mdi mdi-folder-account"></i>
                                <span> Contracts </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('invoices.index') }}">
                                <i class="mdi mdi-cash-refund"></i>
                                <span> Invoices </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    @endif
@endif
