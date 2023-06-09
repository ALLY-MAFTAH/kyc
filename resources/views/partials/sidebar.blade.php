<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
        <a style="text-decoration: none" class="sidebar-brand brand-logo" href="{{ route('home') }}"><span
                class="app-name">KYC System</span></a>
        <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="{{ route('home') }}"><img
                src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="pl-5 pt-2 pb-3 nav-item nav-profile">
            {{-- <a href="{{ route('home') }}" class="nav-link"> --}}
            <img src="{{ asset('assets/images/logo.png') }}" height="90px" alt="logo" />
            {{-- </a> --}}
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if (!Auth::user()->market_id)
            <li
                class="nav-item {{ request()->routeIs('markets.show') || request()->routeIs('customers.show') ? 'active' : '' }}">
                <a class="nav-link " href="{{ route('markets.index') }}">
                    <i class="mdi mdi mdi-hospital-building menu-icon"></i>
                    <span class="menu-title">Markets</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frames.index') }}">
                    <i class="mdi mdi-image-filter-frames menu-icon"></i>
                    <span class="menu-title">Frames</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('stalls.index') }}">
                    <i class="mdi mdi-table menu-icon"></i>
                    <span class="menu-title">Stalls</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('customers.admin_show') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('customers.index') }}">
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                    <span class="menu-title">Customers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('payments.index') }}">
                    <i class="mdi mdi-square-inc-cash menu-icon"></i>
                    <span class="menu-title">Payments</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="mdi mdi-contacts menu-icon"></i>
                    <span class="menu-title">Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                    aria-controls="ui-basic">
                    <i class="mdi mdi-file-document menu-icon"></i>
                    <span class="menu-title">Reports</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin_reports.markets') }}">Markets Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin_reports.customers') }}">Customers Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin_reports.payments') }}">Payments Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin_reports.frame_stall') }}">Frames & Stalls
                                Report</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('settings.index') }}">
                    <i class="mdi mdi-settings menu-icon"></i>
                    <span class="menu-title">Settings</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->market_id && Auth::user()->status && Auth::user()->is_manager)
            <li
                class="nav-item {{ request()->routeIs('markets.show') || request()->routeIs('customers.show') ? 'active' : '' }}">
                <a id="market-link"class="nav-link" type="button">
                    <i class="mdi mdi-hospital-building menu-icon"></i>
                    <span class="menu-title">Market</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('payments.manager_index') }}">
                    <i class="mdi mdi-square-inc-cash menu-icon"></i>
                    <span class="menu-title">Payments</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
                    aria-controls="ui-basic">
                    <i class="mdi mdi-file-document menu-icon"></i>
                    <span class="menu-title">Reports</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('manager_reports.customers') }}">Customers Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('manager_reports.payments') }}">Payments Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('manager_reports.frame_stall') }}">Frames & Stalls
                                Report</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        <li class="nav-item sidebar-actions">
            <div class="nav-link">
                <div class="mt-4">
                    <div class="border-none">
                        <p class="text-black">Notifications</p>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>
