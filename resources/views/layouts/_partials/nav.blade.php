@php
    $frontMenus = include resource_path('views/layouts/_menus/front-menus.php');
@endphp

<nav class="navbar navbar-expand-xl" data-bs-theme="dark">
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
