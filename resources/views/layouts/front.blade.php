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
    <title>@yield('title', config('settings.meta_title', '')) - AutoGenius</title>
    <meta name="description"
        content="@yield('meta_description', config('settings.meta_description', 'A brief, default site description.'))">
    <meta name="keywords"
        content="@yield('meta_keywords', config('settings.meta_keywords', 'default, keywords, tags'))">
    <!-- END SEO -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="robots" content="noindex">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/twentytwenty.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@26.0.6/build/css/intlTelInput.css">



    <style>
        .iti__dropdown-content {
            background: black !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="preloader">
        <div class="loading-container">
            <div class="loading"></div>
            <div id="loading-icon"><img src="{{ asset('images/logo-icon.png') }}" style="height: 150px;" alt=""></div>
        </div>
    </div>
    @include('layouts._partials.nav')

    @yield('header')
    <!-- Page / Blog Content -->

    @yield('content')

    <!-- Footer -->
    @include('layouts._partials.footer')

    <!-- Scripts -->
    <script src="//cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/parallaxie.js') }}"></script>
    <script src="{{ asset('js/jquery.event.move.js') }}"></script>
    <script src="{{ asset('js/jquery.twentytwenty.js') }}"></script>
    <script src="{{ asset('js/gsap.min.js') }}"></script>
    <script src="{{ asset('js/SplitText.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mb.YTPlayer.min.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/function.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@26.0.6/build/js/intlTelInput.min.js"></script>
    @stack('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const input = document.querySelector("#phone");

            if (!input) {
                console.warn("intl-tel-input: #phone not found in DOM");
                return;
            }

            window.intlTelInput(input, {
                initialCountry: "in",
                loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@26.0.6/build/js/utils.js"),
            });
        });
    </script>

   
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</body>

</html>