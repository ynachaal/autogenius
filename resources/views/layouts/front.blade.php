<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- DYNAMIC SEO METADATA -->
    <title>@yield('meta_title', config('settings.meta_title', 'AutoGenius Private Limited - The Automotive Testing Company'))</title>
    <meta name="description" content="@yield('meta_description', config('settings.meta_description', 'A brief, default site description.'))">
    <meta name="keywords" content="@yield('meta_keywords', config('settings.meta_keywords', 'default, keywords, tags'))">
    <!-- END SEO -->

    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Header / Navigation -->
    <header class="{{ request()->is('/') ? 'home-header' : '' }}">
        @include('layouts._partials.nav')
    </header>

    <!-- Main Content -->
    <main>


        <!-- Page / Category / Blog Header -->
        @yield('header')

        <!-- Page / Blog Content -->
        @yield('content')

    </main>

    <!-- Footer -->
     <footer class="{{ request()->is('/') ? 'home-footer' : '' }}">
        @include('layouts._partials.footer')
    </footer>

    <!-- Scripts -->
    <script src="//cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
