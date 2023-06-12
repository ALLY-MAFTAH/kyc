<nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
    <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
        <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="{{ route('home') }}"><img
                src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" /></a>
        <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize">
            <i class="mdi mdi-menu"></i>
        </button>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                    data-toggle="dropdown">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="count count-varient1">2</span>
                </a>
                <div class="dropdown-menu navbar-dropdown navbar-dropdown-large preview-list"
                    aria-labelledby="notificationDropdown">
                    <h6 class="p-3 mb-0 ">Notifications</h6>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="assets/images/user.png" alt="" class="profile-pic">
                        </div>
                        <div class="preview-item-content">
                            <p class="mb-0">Your Boss <span class="text-small text-muted">received payments
                                    reports</span></p>
                        </div>
                    </a>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="assets/images/user.png" alt="" class="profile-pic">
                        </div>
                        <div class="preview-item-content">
                            <p class="mb-0">MD <span class="text-small text-muted">posted a file in your email</span>
                            </p>
                        </div>
                    </a>

                    <div class="dropdown-divider"></div>
                    <p class="p-3 mb-0 ">View all activities</p>
                </div>
            </li>
            <li class="nav-item nav-search border-0 ml-1 ml-md-3 ml-lg-5 d-none d-md-flex">
                <form class="nav-link form-inline mt-2 mt-md-0">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="mdi mdi-magnify"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right ml-lg-auto">

            <li class="nav-item  nav-profile dropdown border-0">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown">
                    <img class="nav-profile-img mr-2" alt="" src="{{ asset('assets/images/user.png') }}">
                    <span class="profile-name">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu navbar-dropdown " aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="#">
                        <i class="mdi mdi-cached  text-primary"></i> Activity Log </a>
                    <a class="dropdown-item" href="!#"data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="mdi mdi-key  text-warning"></i> Change Password </a>
                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout  text-danger"></i>

                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form> </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password
                </h5>
                <button type="button" style="background-color:red" class=" btn-danger btn-close"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('users.change_password') }}">
                    @csrf
                    @method('PUT')
                    <input type="text" value="{{ Auth::user()->id }}" name="user_id" hidden>
                    <div class="text-start mb-1">
                        <label for="old_password"
                            class="col-form-label text-sm-start">{{ __('Old Password') }}</label>
                        <input id="old_password" type="password" placeholder="Old Password"
                            class="form-control @error('old_password') is-invalid @enderror" name="old_password"
                            autocomplete="old_password" required autofocus>
                        @error('old_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="text-start mb-1">
                        <label for="new_password"
                            class="col-form-label text-sm-start">{{ __('New Password') }}</label>
                        <input id="new_password" type="password" placeholder="New Password"
                            class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                            autocomplete="new_password" required autofocus>
                        @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="text-start mb-1">
                        <label for="confirm_new_password"
                            class="col-form-label text-sm-start">{{ __('Confirm New Password') }}</label>
                        <input id="confirm_new_password" type="password" placeholder="Confirm New Password"
                            class="form-control @error('confirm_new_password') is-invalid @enderror"
                            name="confirm_new_password" autocomplete="confirm_new_password" required autofocus>
                        @error('confirm_new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row mb-1 mt-4">
                        <div class="text-center">
                            <button type="submit" class="btn  btn-outline-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
