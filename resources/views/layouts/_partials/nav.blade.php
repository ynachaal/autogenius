@php
    $frontMenus = include resource_path('views/layouts/_menus/front-menus.php');
@endphp
<header class="header-one header--sticky">
    <div class="container-2">
        <div class="row">
            <div class="col-lg-12">
                <div class="header-wrapper-1">
                    <div class="logo-area-start">
                        <a href="javascript:void(0)" class="logo">
                            <img src="{{ asset('images/logo-3.png') }}" alt="logo_area" width="200">
                        </a>
                    </div>
                    <div class="header-right d-block">
                        <div class="bottom d-flex align-items-center justify-content-between">
                            <div class="nav-area">
                                <ul class="">
                                    @foreach ($frontMenus as $menuItem)
                                        @php
                                            $url = $menuItem['route'] ?? '#';
                                            $isActive = url()->current() === $url;
                                        @endphp

                                        @if (!empty($menuItem['submenu']))
                                            <!-- Dropdown menu -->
                                            <li class="main-nav has-dropdown">
                                                <a class="main-menu {{ $isActive ? 'active' : '' }}" href="javascript:void(0)">
                                                    {{ $menuItem['title'] }}
                                                </a>

                                                <ul class="submenu parent-nav">
                                                    @foreach ($menuItem['submenu'] as $sub)
                                                        <li>
                                                            <a href="{{ $sub['route'] ?? 'javascript:void(0)' }}">
                                                                {{ $sub['title'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <!-- Single menu item -->
                                            <li class="main-nav">
                                                <a class="main-menu {{ $isActive ? 'active' : '' }}" href="{{ $url }}">
                                                    {{ $menuItem['title'] }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="bottom-right">
                                <div class="button-area">
                                    @auth
                                        @php
                                            $dashboardUrl = Auth::user()->role === 'admin'
                                                ? url('/admin/dashboard')
                                                : url('/dashboard');

                                            $isDashboardActive = request()->is('dashboard') || request()->is('admin/dashboard');
                                        @endphp

                                        <a href="{{ $dashboardUrl }}" class="rts-btn btn-border radius-big icon @if($isDashboardActive) active @endif">
                                            Dashboard
                                            <svg width="14" height="14" viewBox="0 0 11 11" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.61999 10.96H5.49999C5.28445 10.96 5.10999 10.7856 5.10999 10.57C5.10999 10.3545 5.28445 10.18 5.49999 10.18H8.61999C9.26518 10.18 9.78999 9.65523 9.78999 9.01004V1.99004C9.78999 1.34485 9.26518 0.820039 8.61999 0.820039H5.49999C5.28445 0.820039 5.10999 0.645579 5.10999 0.430039C5.10999 0.214499 5.28445 0.0400391 5.49999 0.0400391H8.61999C9.69522 0.0400391 10.57 0.914809 10.57 1.99004V9.01004C10.57 10.0853 9.69522 10.96 8.61999 10.96ZM7.33572 5.22431L5.38572 3.27431C5.23336 3.12195 4.98662 3.12195 4.83426 3.27431C4.6819 3.42667 4.6819 3.67341 4.83426 3.82577L6.11853 5.11004H0.819993C0.604453 5.11004 0.429993 5.2845 0.429993 5.50004C0.429993 5.71558 0.604453 5.89004 0.819993 5.89004H6.11853L4.83426 7.17431C4.6819 7.32667 4.6819 7.57341 4.83426 7.72577C4.91044 7.80195 5.01015 7.84004 5.10999 7.84004C5.20983 7.84004 5.30954 7.80195 5.38572 7.72577L7.33572 5.77577C7.48808 5.62341 7.48808 5.37667 7.33572 5.22431Z"
                                                    fill="#FF3600"></path>
                                            </svg>
                                        </a>

                                    @else
                                        <a href="{{ route('login') }}"
                                           class="rts-btn btn-border radius-big icon @if(request()->is('login')) active @endif">
                                            Sign In
                                            <svg width="14" height="14" viewBox="0 0 11 11" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.61999 10.96H5.49999C5.28445 10.96 5.10999 10.7856 5.10999 10.57C5.10999 10.3545 5.28445 10.18 5.49999 10.18H8.61999C9.26518 10.18 9.78999 9.65523 9.78999 9.01004V1.99004C9.78999 1.34485 9.26518 0.820039 8.61999 0.820039H5.49999C5.28445 0.820039 5.10999 0.645579 5.10999 0.430039C5.10999 0.214499 5.28445 0.0400391 5.49999 0.0400391H8.61999C9.69522 0.0400391 10.57 0.914809 10.57 1.99004V9.01004C10.57 10.0853 9.69522 10.96 8.61999 10.96ZM7.33572 5.22431L5.38572 3.27431C5.23336 3.12195 4.98662 3.12195 4.83426 3.27431C4.6819 3.42667 4.6819 3.67341 4.83426 3.82577L6.11853 5.11004H0.819993C0.604453 5.11004 0.429993 5.2845 0.429993 5.50004C0.429993 5.71558 0.604453 5.89004 0.819993 5.89004H6.11853L4.83426 7.17431C4.6819 7.32667 4.6819 7.57341 4.83426 7.72577C4.91044 7.80195 5.01015 7.84004 5.10999 7.84004C5.20983 7.84004 5.30954 7.80195 5.38572 7.72577L7.33572 5.77577C7.48808 5.62341 7.48808 5.37667 7.33572 5.22431Z"
                                                    fill="#FF3600"></path>
                                            </svg>
                                        </a>

{{--                                        <a href="{{ route('register') }}"--}}
{{--                                           class="rts-btn btn-border radius-big icon @if(request()->is('register')) active @endif">--}}
{{--                                            Sign Up--}}
{{--                                        </a>--}}
                                    @endauth
                                </div>

                                <div class="menu-btn" id="menu-btn">
                                    <svg width="55" height="55" viewBox="0 0 55 55" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect width="55" height="55" rx="15" fill="#FF3600"></rect>
                                        <rect x="18" y="33" width="10" height="2" fill="#ffffff"></rect>
                                        <rect x="18" y="26" width="20" height="2" fill="#ffffff"></rect>
                                        <rect x="18" y="19" width="10" height="2" fill="#ffffff"></rect>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<nav class="navbar navbar-expand-xl d-none" data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand logo" href="/">Compass <span>&</span> Coin</a>

        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-xl-0">
                {{-- Dynamic menu items --}}
                @foreach ($frontMenus as $menuItem)
                    @php
                        $url = !empty($menuItem['route']) ? $menuItem['route'] : '#';
                        $isActive = url()->current() == $url;
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link @if ($isActive) active @endif" href="{{ $url }}" aria-current="page">
                            {{ $menuItem['title'] }}
                        </a>
                    </li>
                @endforeach

                {{-- Auth-based menu items --}}
                @auth
                    @php
                        $dashboardUrl = Auth::user()->role === 'admin'
                            ? url('/admin/dashboard')
                            : url('/dashboard');

                        $isDashboardActive = request()->is('dashboard') || request()->is('admin/dashboard');
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link @if ($isDashboardActive) active @endif" href="{{ $dashboardUrl }}">
                            Dashboard
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link login_btn my-lg-0 my-3 w-fit @if (request()->is('login')) active @endif" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link signup_btn w-fit  @if (request()->is('register')) active @endif" href="{{ route('register') }}">
                            Sign Up
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
