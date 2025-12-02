@php
    $frontMenus = include resource_path('views/layouts/_menus/front-menus.php');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <!-- DYNAMIC SEO METADATA -->
    <title>@yield('meta_title', config('settings.meta_title', 'AutoGenius Private Limited - The Automotive Testing Company'))</title>
    <meta name="description" content="@yield('meta_description', config('settings.meta_description', 'A brief, default site description.'))">
    <meta name="keywords" content="@yield('meta_keywords', config('settings.meta_keywords', 'default, keywords, tags'))">
    <!-- END SEO -->

    <link rel="stylesheet" href="{{ asset('css/plugins.css?1') }}">
    <link rel="stylesheet" href="{{ asset('css/magnifying-popup.css') }}">
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('css/rt-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body>
    <div class="loader-wrapper">
        <div class="loader">
        </div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <div class="search-input-area">
        <div class="container">
            <div class="search-input-inner">
                <div class="input-div">
                    <input class="search-input autocomplete" type="text" placeholder="Search by keyword or #">
                    <button><i class="far fa-search"></i></button>
                </div>
            </div>
        </div>
        <div id="close" class="search-close-icon"><i class="far fa-times"></i></div>
    </div>
    <div id="anywhere-home">
    </div>
    <!-- progress area start -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                  style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>
    <!-- progress area end -->
    <div class="rts-wrapper">
        <div class="rts-wrapper-inner">
            <!-- Header / Navigation -->
            <header class="{{ request()->is('/') ? 'home-header' : '' }}">
                @include('layouts._partials.nav')
            </header>
            <!-- Page / Category / Blog Header -->
            @yield('header')

            <!-- Page / Blog Content -->
            @yield('content')
        </div>
    </div>
    <!-- header style two -->
    <div id="side-bar" class="side-bar header-two">
        <button class="close-icon-menu">X</button>
        <!-- mobile menu area start -->
        <div class="mobile-menu-main">
            <nav class="nav-main mainmenu-nav mt--30">
                <ul class="mainmenu metismenu" id="mobile-menu-active">
                    @foreach ($frontMenus as $menuItem)
                        @php
                            $url = $menuItem['route'] ?? '#';
                            $isActive = url()->current() === $url;
                        @endphp

                        @if (!empty($menuItem['submenu']))
                            <!-- Dropdown menu -->
                            <li class="has-droupdown">
                                <a class="main {{ $isActive ? 'active' : '' }}" href="javascript:void(0)">
                                    {{ $menuItem['title'] }}
                                </a>

                                <ul class="submenu mm-collapse">
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
                            <li>
                                <a class="main {{ $isActive ? 'active' : '' }}" href="{{ $url }}">
                                    {{ $menuItem['title'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </nav>

            <div class="rts-social-style-one pl--20 mt--50">
                <ul>
                    <li><a href="javascript:void(0)"><img src="{{ asset('images/facebook.svg') }}" alt=""></a></li>
                    <li><a href="javascript:void(0)"><img src="{{ asset('images/instagram.svg') }}" alt=""></a></li>
                    <li><a href="javascript:void(0)"><img src="{{ asset('images/whatsapp.svg') }}" alt=""></a></li>
                </ul>
            </div>
        </div>
        <!-- mobile menu area end -->
    </div>
    <!-- Footer -->
    @include('layouts._partials.footer')

    <!-- Scripts -->
    <script src="//cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="{{ asset('js/counter-up.js') }}"></script>
    <script src="{{ asset('js/contact-form.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/js/swiper.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.6/metisMenu.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jarallax/2.2.1/jarallax.min.js"></script>
    <script src="{{ asset('js/smooth-scroll.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
    <!-- main js here -->
    <script src="{{ asset('js/main.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    @stack('scripts')
</body>
</html>
