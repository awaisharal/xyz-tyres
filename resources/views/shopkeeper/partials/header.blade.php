<div class="wrapper">
    <div class="iq-top-navbar">
        <div class="container">
            <div class="iq-navbar-custom">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                        <i class="ri-menu-line wrapper-menu"></i>
                        <a href="{{ route('dashboard') }}" class="header-logo">
                            <img src="/assets/images/logo.png" class="img-fluid rounded-normal light-logo" alt="logo">
                            <img src="/assets/images/logo-white.png" class="img-fluid rounded-normal darkmode-logo" alt="logo">
                        </a>
                    </div>
                    <div class="iq-menu-horizontal">
                        <nav class="iq-sidebar-menu">
                            <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
                                <a href="index.html" class="header-logo">
                                    <img src="../assets/images/logo.png" class="img-fluid rounded-normal" alt="logo">
                                </a>
                                <div class="iq-menu-bt-sidebar">
                                    <i class="las la-bars wrapper-menu"></i>
                                </div>
                            </div>
                            <ul id="iq-sidebar-toggle" class="iq-menu d-flex">
                                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <a href="{{ route('dashboard') }}">
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('services.index') ? 'active' : '' }}">
                                    <a href="{{ route('services.index') }}">
                                        <span>Services</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('about.me') ? 'active' : '' }}">
                                    <a href="{{ route('aboutme') }}">
                                        <span>About me</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-light p-0">
                        
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-label="Toggle navigation">
                            <i class="ri-menu-3-line"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto navbar-list align-items-center">
                              
                                <li class="nav-item nav-icon dropdown">
                                    <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="las la-bell"></i>
                                        <span class="badge badge-primary count-mail rounded-circle">2</span>
                                        <span class="bg-primary"></span>
                                    </a>
                                    <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <div class="card shadow-none m-0">
                                            <div class="card-body p-0 ">
                                                <div class="cust-title p-3">
                                                    <h5 class="mb-0">Notifications</h5>
                                                </div>
                                                <div class="p-2">
                                                    <a href="#" class="iq-sub-card">
                                                        <div class="media align-items-center cust-card p-2">
                                                            <div class="">
                                                                <img class="avatar-40 rounded-small" src="../assets/images/user/u-1.jpg" alt="01">
                                                            </div>
                                                            <div class="media-body ml-3">
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <h6 class="mb-0">Dummy</h6>
                                                                    <small class="mb-0">02 Min Ago</small>
                                                                </div>
                                                                <small class="mb-0">Dummy</small>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <a class="right-ic btn-block position-relative p-3 border-top text-center" href="#" role="button">
                                                    See All Notification
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="caption-content">
                                    <a href="#" class="search-toggle dropdown-toggle d-flex align-items-center" id="dropdownMenuButton3" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <img src="../assets/images/user/01.jpg" class="avatar-40 img-fluid rounded" alt="user">
                                        <div class="caption ml-3">
                                            <h6 class="mb-0 line-height">{{ Auth::user()->name ?? 'No name' }}<i class="las la-angle-down ml-3"></i></h6>
                                        </div>
                                    </a>
                                    <div class="iq-sub-dropdown dropdown-menu user-dropdown" aria-labelledby="dropdownMenuButton3">
                                        <div class="card m-0">
                                            <div class="card-body p-0">
                                                <div class="py-3">
                                                    <a href="../app/user-profile.html" class="iq-sub-card">
                                                        <div class="media align-items-center">
                                                            <i class="ri-user-line mr-3"></i>
                                                            <h6>Account Settings</h6>
                                                        </div>
                                                    </a>
                                                </div>
                                               
                                                <a class="right-ic p-3 border-top btn-block position-relative text-center" href="javascript:void(0);" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                  Logout
                                              </a>
                                              
                                              <!-- Logout Form -->
                                              <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                                                  @csrf
                                              </form>
                                              
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
      </div>
  </div>