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
        'title' => 'Contact Submissions',
        'icon' => 'bi-ui-checks',
        'route' => route('admin.contact-submissions.index'),
        'active' => Route::is('admin.contact-submissions.index'),
    ],
     [
        'title' => 'Services',
        'icon' => 'bi-person-fill',
        'route' => route('admin.services.index'),
        'active' => Route::is('admin.services.index'),
    ],
     [
        'title' => 'Brands',
        'icon' => 'bi-tag',
        'route' => route('admin.brands.index'),
        'active' => Route::is('admin.brands.index'),
    ],
    [
        'title' => 'Email Templates',
        'icon' => 'bi-envelope-paper',
        'route' => route('admin.email-templates.index'),
        'active' => Route::is('admin.email-templates.index'),
    ],
    [
        'title' => 'Blogs',
        'icon' => 'bi-journal-text',
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
        'title' => 'Slider',
        'icon' => 'bi-journal-text',
        'children' => [
            [
                'title' => 'Slider',
                'route' => route('admin.sliders.index'),
                'active' => Route::is('admin.sliders.*'),
            ],
            [
                'title' => 'Slider Categories',
                'route' => route('admin.slider-categories.index'),
                'active' => Route::is('admin.slider-categories.*'),
            ],
        ],
        'active' => Route::is('admin.slider-categories.*') || Route::is('admin.sliders.*'),
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
        'title' => 'Settings',
        'icon' => 'bi-gear',
        'route' => route('admin.settings.index'),
        'active' => Route::is('admin.settings.index'),
    ],
];
