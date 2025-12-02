<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ Route::is('admin.users.index') ? 'active' : '' }}">
            <i class="nav-icon bi bi-person-fill"></i>
            <p>Users</p>
        </a>
    </li>

    <li class="nav-item {{ Route::is('admin.blogs.*') || Route::is('admin.blog-categories.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ Route::is('admin.blogs.*') || Route::is('admin.blog-categories.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-journal-text"></i>
            <p>
                Blogs
                <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ Route::is('admin.blogs.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Blogs</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.blog-categories.index') }}" class="nav-link {{ Route::is('admin.blog-categories.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Blog Categories</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item {{ Route::is('admin.menus.*') || Route::is('admin.menus.*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ Route::is('admin.menus.*') || Route::is('admin.menu-categories.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-journal-text"></i>
            <p>
                Menus
                <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('admin.menus.index') }}" class="nav-link {{ Route::is('admin.menus.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Menus</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.menu-categories.index') }}" class="nav-link {{ Route::is('admin.menu-categories.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-circle"></i>
                    <p>Menu Categories</p>
                </a>
            </li>
        </ul>
    </li>


    <li class="nav-item">
        <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ Route::is('admin.faqs.index') ? 'active' : '' }}">
            <i class="nav-icon bi bi-question-circle"></i>
            <p>Faqs</p>
        </a>
    </li>

   
    <li class="nav-item">
        <a href="{{ route('admin.pages.index') }}" class="nav-link {{ Route::is('admin.pages.index') ? 'active' : '' }}">
            <i class="nav-icon bi bi-files"></i>
            <p>Pages</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ Route::is('admin.settings.index') ? 'active' : '' }}">
            <i class="nav-icon bi bi-gear"></i>
            <p>Settings</p>
        </a>
    </li>
</ul>