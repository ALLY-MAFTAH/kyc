<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
        <a style="text-decoration: none" class="sidebar-brand brand-logo" href="{{ route('home') }}"><span
                class="app-name">KYC System</span></a>
        <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="{{ route('home') }}"><img
                src="{{asset('assets/images/logo-mini.svg')}}" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{ route('home') }}" class="nav-link">
                <img src="{{asset('assets/images/logo.png')}}" height="90px" alt="logo" />
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('markets.index') }}">
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
            <a class="nav-link" href="{{ route('cages.index') }}">
                <i class="mdi mdi-table menu-icon"></i>
                <span class="menu-title">Cages</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customers.index') }}">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Customers</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('customers.index') }}">
                <i class="mdi mdi-square-inc-cash menu-icon"></i>
                <span class="menu-title">Payments</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="mdi mdi-file-document menu-icon"></i>
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/buttons.html">Customers Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/dropdowns.html">Markets Report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages/ui-features/typography.html">Payments Report</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="mdi mdi-contacts menu-icon"></i>
                <span class="menu-title">Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('settings.index') }}">
                <i class="mdi mdi-settings menu-icon"></i>
                <span class="menu-title">Settings</span>
            </a>
        </li>


        <li class="nav-item sidebar-actions">
            <div class="nav-link">
                <div class="mt-4">
                    <div class="border-none">
                        <p class="text-black">Notifications</p>
                    </div>
                    <ul class="mt-4 pl-0">
                        <li><a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
</nav>
