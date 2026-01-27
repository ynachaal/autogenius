@php
    $frontMenus = include resource_path('views/layouts/_menus/front-menus.php');
@endphp
<header class="main-header">
    <div class="header-sticky bg-section">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-icon.png') }}" alt="Logo">
                </a>
                <div class="collapse navbar-collapse main-menu">
                    <div class="nav-menu-wrapper">
                        <ul class="navbar-nav mr-auto" id="menu">
                            @foreach ($frontMenus as $menuItem)
                                @php
                                    $url = $menuItem['route'] ?? '#';
                                    $isActive = url()->current() === $url;
                                @endphp

                                @if (!empty($menuItem['submenu']))
                                    <li class="nav-item submenu">
                                        <a class="nav-link {{ $isActive ? 'active' : '' }}" href="javascript:void(0)">
                                            {{ $menuItem['title'] }}
                                        </a>
                                        <ul>
                                            @foreach ($menuItem['submenu'] as $sub)
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ $sub['route'] ?? 'javascript:void(0)' }}">
                                                        {{ $sub['title'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link {{ $isActive ? 'active' : '' }}" href="{{ $url }}">
                                            {{ $menuItem['title'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="header-auth d-flex align-items-center ms-auto">
                        @auth
                            @php
                                // Logic from your example: redirect based on role
                                $dashboardUrl = Auth::user()->role === '01'
                                    ? url('/admin/dashboard')
                                    : url('/dashboard');

                                $isDashboardActive = request()->is('dashboard') || request()->is('admin/dashboard');
                            @endphp

                            <a href="{{ $dashboardUrl }}" class="nav-link text-white me-3 @if($isDashboardActive) active @endif">
                                <i class="fa fa-tachometer-alt"></i> Dashboard
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <a href="{{ route('logout') }}" class="nav-link text-white me-3"
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fa fa-sign-out-alt"></i> Logout
                                </a>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="nav-link text-white me-3 @if(request()->is('login')) active @endif">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-link text-white me-3 @if(request()->is('register')) active @endif">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>

                    <div class="search">
                        <a class="text-white search-toggle" href="#">
                            <i class="fa fa-search"></i> Search
                        </a>
                    </div>
                </div>
                <div class="navbar-toggle"></div>
            </div>
        </nav>
        <div class="responsive-menu"></div>
    </div>
</header>
<div class="search_main" id="searchOverlay">
    <button type="button" class="btn-close search-close shadow-none"></button>

    <div class="container">
        <div class="col-md-8 mx-auto">
            <div class="input-group search-box">
                <input type="text" class="form-control" placeholder="Search...">
                <button class="btn search-btn" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const toggleBtn = document.querySelector('.search-toggle');
    const overlay = document.getElementById('searchOverlay');
    const closeBtn = document.querySelector('.search-close');
    const searchBox = overlay.querySelector('.search-box');

    function openSearch(e) {
        e.preventDefault(); // stop #
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        overlay.querySelector('input').focus();
    }

    function closeSearch() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    toggleBtn.addEventListener('click', openSearch);
    closeBtn.addEventListener('click', closeSearch);

    // click outside input group
    overlay.addEventListener('click', (e) => {
        if (!searchBox.contains(e.target)) {
            closeSearch();
        }
    });

    // ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeSearch();
        }
    });
</script>
