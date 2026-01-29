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
    <meta name="description" content="@yield('meta_description', config('settings.meta_description', 'A brief, default site description.'))">
    <meta name="keywords" content="@yield('meta_keywords', config('settings.meta_keywords', 'default, keywords, tags'))">
    <!-- END SEO -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/twentytwenty.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

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
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @stack('scripts')

    <script>
        const locations = [
            { name: "", top: "59%", left: "8%" },
            { name: "", top: "25%", left: "30%" },
            { name: "", top: "45%", left: "50%" },
            { name: "", top: "33%", left: "25%" },
            { name: "", top: "51%", left: "16%" },
            { name: "", top: "42%", left: "11%" },
            { name: "", top: "85%", left: "10.5%" },
            { name: "", top: "33%", left: "4%" },
            { name: "", top: "24%", left: "12%" },
            { name: "", top: "72%", left: "17%" },
            { name: "", top: "15%", left: "34%" },
            { name: "", top: "22%", left: "44%" },
            { name: "", top: "9%", left: "72%" },
            { name: "", top: "22%", left: "67%" },
            { name: "", top: "22%", left: "44%" },
            { name: "", top: "45%", left: "30%" },
            { name: "", top: "52%", left: "38%" },
            { name: "", top: "35%", left: "42%" },
            { name: "", top: "52%", left: "38%" },
            { name: "", top: "61%", left: "25%" },
            { name: "", top: "23%", left: "57%" },
            { name: "", top: "14%", left: "57%" },
            { name: "", top: "14%", left: "85%" },
            { name: "", top: "26%", left: "81%" },
            { name: "", top: "14%", left: "17%" },
            { name: "", top: "4%", left: "17%" },
            { name: "", top: "22%", left: "22%" },
            { name: "", top: "33%", left: "15%" },
            { name: "", top: "62%", left: "16%" },
            { name: "", top: "49%", left: "5%" },
            { name: "", top: "70%", left: "8%" },
            { name: "", top: "13%", left: "49%" },
            { name: "", top: "33%", left: "64%" },
            { name: "", top: "34%", left: "33%" },
            { name: "", top: "11%", left: "27%" },
            { name: "", top: "41%", left: "21%" },
            { name: "", top: "43%", left: "38%" },
            { name: "", top: "62%", left: "33%" },
            { name: "", top: "71%", left: "28%" },
            { name: "", top: "52%", left: "26%" },
            { name: "", top: "26%", left: "37%" },
            { name: "", top: "54%", left: "46%" },
            { name: "", top: "63%", left: "41%" },
            { name: "", top: "38%", left: "56%" },
            { name: "", top: "48%", left: "58%" },
            { name: "", top: "29%", left: "50%" },
            { name: "", top: "4%", left: "54%" },
            { name: "", top: "17%", left: "77%" },
            { name: "", top: "31%", left: "73%" },
            { name: "", top: "36%", left: "88%" },
            { name: "", top: "23%", left: "90%" },
            { name: "", top: "6%", left: "89%" },
            { name: "", top: "7%", left: "80%" },
            { name: "", top: "81%", left: "19%" },
            { name: "", top: "13%", left: "64%" },
            { name: "", top: "91%", left: "17%" },
        ];
        const map = document.querySelector(".map-wrapper");
        locations.forEach(loc => {
            const pin = document.createElement("div");
            pin.className = "map-pin";
            pin.style.top = loc.top;
            pin.style.left = loc.left;

            //
            //pin.innerHTML = `<span>${loc.name}</span>`;
            map.appendChild(pin);
        });
    </script>
    <div
    class="cf-turnstile"
    data-sitekey="{{ config('services.turnstile.site_key') }}"
    data-size="invisible"
    data-callback="onTurnstileSuccess">
</div>
<script>
    const form = document.getElementById('consultationForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        submitBtn.disabled = true;

        turnstile.execute();
    });

    function onTurnstileSuccess(token) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'cf-turnstile-response';
        input.value = token;

        form.appendChild(input);
        form.submit();
    }
</script>
</body>
</html>
