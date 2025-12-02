<?php
return [
    [
        'title' => 'View Website',
        'icon' => 'bi-globe',
        'route' => '/',
        'target' => '_blank',
    ],
    [
        'title' => 'Dashboard',
        'icon' => 'bi-speedometer',
        'route' => route('admin.dashboard'),
        'active' => Route::is('admin.dashboard'),
    ],
    [
        'title' => 'Users',
        'icon' => 'bi-person-fill',
        'route' => route('admin.users.index'),
        'active' => Route::is('admin.users.index'),
    ],
    [
        'title' => 'Blogs',
        'icon' => 'bi-newspaper',
        'children' => [
            [
                'title' => 'Blogs',
                'route' => route('admin.blogs.index'),
                'active' => Route::is('admin.blogs.*'),
            ],
            [
                'title' => 'Blog Categories',
                'route' => route('admin.blog-categories.index'),
                'active' => Route::is('admin.blog-categories.*'),
            ],
        ],
        'active' => Route::is('admin.blogs.*') || Route::is('admin.blog-categories.*'),
    ],
    [
        'title' => 'Properties',
        'icon' => 'bi-building',
        'children' => [
            [
                'title' => 'Property Areas',
                'route' => route('admin.property-areas.index'),
                'active' => Route::is('admin.property-areas.*'),
            ],
            [
                'title' => 'Property Types',
                'route' => route('admin.property-types.index'),
                'active' => Route::is('admin.property-types.*'),
            ],
            [
                'title' => 'Properties',
                'route' => route('admin.properties.index'),
                'active' => Route::is('admin.properties.*'),
            ],
        ],
        'active' => Route::is('admin.properties.*') || Route::is('admin.property-areas.*') || Route::is('admin.property-types.*'),
    ],
    [
        'title' => 'Email Template',
        'icon' => 'bi-envelope',
        'route' => route('admin.email-templates.index'),
        'active' => Route::is('admin.email-templates.index'),
    ],
    /*  [
        'title' => 'Menus',
        'icon' => 'bi-journal-text',
        'children' => [
            [
                'title' => 'Menus',
                'route' => route('admin.menus.index'),
                'active' => Route::is('admin.menus.*'),
            ],
            [
                'title' => 'Menu Categories',
                'route' => route('admin.menu-categories.index'),
                'active' => Route::is('admin.menu-categories.*'),
            ],
        ],
        'active' => Route::is('admin.menus.*') || Route::is('admin.menu-categories.*'),
    ], */
    [
        'title' => 'Homepage',
        'icon' => 'bi-house',
        'children' => [
            [
                'title' => 'Developer Partners',
                'route' => route('admin.developer-partners.index'),
                'active' => Route::is('admin.developer-partners.*'),
            ],
            [
                'title' => 'Why Choose Us',
                'route' => route('admin.why-choose-us.index'),
                'active' => Route::is('admin.why-choose-us.*'),
            ],

        ],
        'active' => Route::is('admin.developer-partners.*') || Route::is('admin.why-choose-us.*'),
    ],
    [
        'title' => 'Faqs',
        'icon' => 'bi-question-circle',
        'route' => route('admin.faqs.index'),
        'active' => Route::is('admin.faqs.index'),
    ],
    [
        'title' => 'Pages',
        'icon' => 'bi-files',
        'route' => route('admin.pages.index'),
        'active' => Route::is('admin.pages.index'),
    ],
    [
        'title' => 'Contact',
        'icon' => 'bi-envelope',
        'route' => route('admin.contact-submissions.index'),
        'active' => Route::is('admin.contact-submissions.index'),
    ],
    [
        'title' => 'Settings',
        'icon' => 'bi-gear',
        'route' => route('admin.settings.index'),
        'active' => Route::is('admin.settings.index'),
    ],
];
