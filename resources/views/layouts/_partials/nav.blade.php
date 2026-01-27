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

                    <div class="search">
                        <a class="text-white search-toggle" href="#">
                            <i class="fa fa-search"></i> Search
                        </a>
                    </div> 
                    <div class="header-auth d-flex align-items-center ms-auto">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item submenu">
                                <a href="javascript:void(0)" class="nav-link bg-transparent">
                                    <img src="{{ asset('images/user-icon.svg') }}" class="img-fluid" alt="User">
                                </a>
                                <ul class="submenu-dropdown">
                                    @auth
                                        @php
                                            $dashboardUrl = Auth::user()->role === '01'
                                                ? url('/admin/dashboard')
                                                : url('/dashboard');
                                        @endphp
                                        <li>
                                            <a class="nav-link" href="{{ $dashboardUrl }}">Dashboard</a>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                                            </form>
                                        </li>
                                    @else
                                        <li>
                                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                                        </li>
                                        @if (Route::has('register'))
                                            <li>
                                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                                            </li>
                                        @endif
                                    @endauth
                                </ul>
                            </li>
                        </ul>
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
