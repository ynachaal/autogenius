<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">
    <meta name="title" content="{{ config('app.name', 'Laravel') }}">
    <meta name="author" content="Your Name">
    <meta name="description" content="Laravel application with AdminLTE 4 design">
    <meta name="keywords" content="laravel, adminlte, bootstrap, admin dashboard">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media='all'">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous">

    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta1/dist/css/adminlte.min.css"
        crossorigin="anonymous">

    <!-- Quill CSS -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

    <!-- jQuery Validate CSS (optional for styling validation messages) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.css"
        crossorigin="anonymous">

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js" crossorigin="anonymous"></script>

    <!-- jQuery Validate -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('css/admin.css?123') }}">

    @vite(['resources/js/app.js'])

    @stack('styles')
</head>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <!-- Start Navbar Links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
                <!-- End Navbar Links -->
                <ul class="navbar-nav ms-auto">
                    <!-- User Menu Dropdown -->
                    @if(Auth::check())
                        <li class="nav-item dropdown user-menu">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ asset('assets/img/user2-160x160.jpg') }}"
                                    class="user-image rounded-circle shadow" alt="User Image">
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                                <li class="user-header text-bg-primary">
                                    <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="rounded-circle shadow"
                                        alt="User Image">
                                    <p>
                                        {{ Auth::user()->name }} -
                                        {{ Auth::user()->role === 'admin' ? 'Administrator' : 'User' }}
                                        <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">Profile</a>
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
                                        out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="" class="brand-link">
                    <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="App Logo"
                        class="brand-image opacity-75 shadow">
                    <span class="brand-text fw-light">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                        aria-label="Main navigation">
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            @include('layouts.navigation-admin')
                        @else
                            @include('layouts.navigation-user')
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="app-main">
            @isset($header)
                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">{{ $header }}</div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-end">
                                    <li class="breadcrumb-item"><a href="">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ strip_tags($header) }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset

            <div class="app-content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">Anything you want</div>
            <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}"
                    class="text-decoration-none">{{ config('app.name', 'Laravel') }}</a>.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta1/dist/js/adminlte.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js" crossorigin="anonymous"></script>

    <script>
        // OverlayScrollbars Configuration
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }

            // SweetAlert2 Flash Messages
            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'shadow-lg bg-white text-dark'
                    }
                });
            @endif
            @if (session('error') || session('status'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error/Status',
                    text: '{{ session('error') ?? session('status') }}',
                    customClass: {
                        popup: 'shadow-lg bg-white text-dark rounded-3'
                    }
                });
            @endif

            // Quill Editor Initialization
            const editorElement = document.getElementById('editor');
            if (editorElement) {
                const toolbarOptions = [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ];
                quill = new Quill('#editor', {
                    modules: { toolbar: toolbarOptions },
                    placeholder: 'Write your content here...',
                    theme: 'snow'
                });
                const initialContent = document.getElementById('content')?.value;
                if (initialContent) quill.root.innerHTML = initialContent;
            }
        });

        window.syncQuillContent = function () {
            if (!quill) return true;
            document.getElementById('content').value = quill.root.innerHTML;
            return true;
        }

        window.showConfirmationModal = function (formId, itemName, itemType = 'item') {
            if (!Swal) return false;
            Swal.fire({
                title: 'Are you absolutely sure?',
                html: `You are about to delete the ${itemType}: <strong>"${itemName}"</strong>.<br>This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it',
                customClass: {
                    container: 'bg-white bg-opacity-75',
                    popup: 'bg-white text-dark rounded-3 shadow-lg',
                    title: 'text-dark',
                    htmlContainer: 'text-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) document.getElementById(formId).submit();
            });
            return false;
        }
    </script>

    @stack('scripts')
</body>

</html>
