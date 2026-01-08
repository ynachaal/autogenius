@php
$admin_menus = include resource_path('views/layouts/_menus/admin-menus.php');
@endphp

<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    @foreach($admin_menus as $module)
        @if(isset($module['children']))
            <li class="nav-item {{ $module['active'] ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $module['active'] ? 'active' : '' }}">
                    <i class="nav-icon bi {{ $module['icon'] }}"></i>
                    <p>
                        {{ $module['title'] }}
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach($module['children'] as $child)
                        <li class="nav-item">
                            <a href="{{ $child['route'] }}" class="nav-link {{ $child['active'] ? 'active' : '' }}">
                                <i class="nav-icon bi bi-dash-lg"></i>
                                <p>{{ $child['title'] }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li class="nav-item">
                <a href="{{ $module['route'] }}" target="{{ $module['target'] ?? '_self' }}" class="nav-link {{ $module['active'] ?? false ? 'active' : '' }}">
                    <i class="nav-icon bi {{ $module['icon'] }}"></i>
                    <p>{{ $module['title'] }}</p>
                </a>
            </li>
        @endif
    @endforeach
</ul>
