<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">

    <title>{{ config('settings.site_name', '') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta1/dist/css/adminlte.min.css" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/tinymce@7.4.1/tinymce.min.js" referrerpolicy="origin"></script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('css/admin.css?123') }}">
    @stack('styles')
    
    <style>
        /* Hide TinyMCE upgrade advertisement */
        .tox-promotion, .tox-statusbar__branding { display: none !important; }
    </style>
</head>

<body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="bi bi-list"></i></a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @if(Auth::check())
                        <li class="nav-item dropdown user-menu">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="user-image rounded-circle shadow" alt="User Image">
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                                <li class="user-header text-bg-primary">
                                    <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="rounded-circle shadow" alt="User Image">
                                    <p>{{ Auth::user()->name }} - {{ Auth::user()->role === 'admin' ? 'Administrator' : 'User' }}</p>
                                </li>
                                <li class="user-footer">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">Profile</a>
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="" class="brand-link">
                    <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="App Logo" class="brand-image opacity-75 shadow">
                    <span class="brand-text fw-light">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">
                        @if(Auth::check() && Auth::user()->role === '01')
                            @include('layouts.navigation-admin')
                        @else
                            @include('layouts.navigation-user')
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        <main class="app-main">
            @isset($header)
                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">{{ $header }}</div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-end">
                                    <li class="breadcrumb-item"><a href="">Home</a></li>
                                    <li class="breadcrumb-item active">{{ strip_tags($header) }}</li>
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

        <footer class="app-footer text-center">
            <span>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}"
                    class="text-decoration-none">{{ config('settings.site_name', '') }}</a>.</span>
            {{ config('settings.footer_text', '') }}
        </footer>
    </div>

    <div class="modal fade" id="imageBrowserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Existing Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="imageBrowserBody">
                        <p class="text-center text-muted">Loading images...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="uploadNewImageBtn">Upload New Image</button>
                </div>
            </div>
        </div>
    </div>
    <input type="file" id="tinymce-file-upload-input" accept="image/*" style="display: none;">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta1/dist/js/adminlte.min.js" crossorigin="anonymous"></script>

    <script>
        let tinymceEditorInstance = null;

        // 1. TinyMCE Class-based Initialization
        function initTinyMCE() {
            tinymce.init({
                selector: '.tinymce-editor', // Target all textareas with this class
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | bullist numlist | link image media | code fullscreen',
                menubar: 'edit insert view format table tools help',
                height: 400,
                content_style: 'body { font-family: Inter, sans-serif; font-size: 14px }',
                license_key: 'gpl',
                
                // Image Browser Integration
                file_picker_types: 'image',
                file_picker_callback: function (callback, value, meta) {
                    if (meta.filetype === 'image') {
                        openImageBrowserModal(this);
                    }
                },
                setup: function (editor) {
                    // Sync content to textarea on change for form submission
                    editor.on('change keyup', function () {
                        editor.save(); 
                    });
                }
            });
        }

        // 2. Custom Image Browser Logic
        function openImageBrowserModal(editor) {
            tinymceEditorInstance = editor;
            const modalEl = document.getElementById('imageBrowserModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
            
            fetchImages(1);

            // Handle New Upload
            const uploadBtn = document.getElementById('uploadNewImageBtn');
            const uploadInput = document.getElementById('tinymce-file-upload-input');
            
            uploadBtn.onclick = () => uploadInput.click();
            
            uploadInput.onchange = function() {
                if (this.files.length === 0) return;
                const file = this.files[0];
                const formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route("tinymce.upload") }}', { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        tinymceEditorInstance.insertContent(`<img src="${data.location}" alt="${file.name}" />`);
                        modal.hide();
                    }).catch(err => alert('Upload failed.'));
            };
        }

        function fetchImages(page = 1) {
            const body = document.getElementById('imageBrowserBody');
            fetch(`{{ route("tinymce.images") }}?page=${page}`)
                .then(res => res.json())
                .then(data => {
                    body.innerHTML = '';
                    data.data.forEach(img => {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 mb-3';
                        col.innerHTML = `<div class="card shadow-sm" style="cursor:pointer">
                            <img src="${img.url}" class="card-img-top" style="height:120px; object-fit:cover">
                        </div>`;
                        col.onclick = () => {
                            tinymceEditorInstance.insertContent(`<img src="${img.url}" />`);
                            bootstrap.Modal.getInstance(document.getElementById('imageBrowserModal')).hide();
                        };
                        body.appendChild(col);
                    });
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            initTinyMCE();

            // OverlayScrollbars
            const sidebarWrapper = document.querySelector('.sidebar-wrapper');
            if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, { scrollbars: { theme: 'os-theme-light', autoHide: 'leave', clickScroll: true } });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>