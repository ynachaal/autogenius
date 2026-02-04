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
        'title' => 'Submissions',
        'icon' => 'bi-inbox',

        'children' => [
            [
                'title' => 'Contact Submissions',
                'route' => route('admin.contact-submissions.index'),
                'active' => Route::is('admin.contact-submissions.*'),
            ],
            [
                'title' => 'Smart car requirements',
                'route' => route('admin.leads.index'),
                'active' => Route::is('admin.leads.*'),
            ],
            [
                'title' => 'Consultations',
                'route' => route('admin.consultations.index'),
                'active' => Route::is('admin.consultations.*'),
            ],
        ],

        // Parent active if any child is active
        'active' =>
          Route::is('admin.leads.*') ||
            Route::is('admin.contact-submissions.*') ||
            Route::is('admin.consultations.*'),
    ],
    [
        'title' => 'Management',
        'icon' => 'bi-gear',

        'children' => [
            [
                'title' => 'Services',
                'route' => route('admin.services.index'),
                'active' => Route::is('admin.services.index'),
            ],
            [
                'title' => 'Brands',
                'route' => route('admin.brands.index'),
                'active' => Route::is('admin.brands.index'),
            ],
        ],

        // Parent active if any child is active
        'active' => Route::is('admin.services.index') || Route::is('admin.brands.index'),
    ],

    [
        'title' => 'Homepage',
        'icon' => 'bi-house',

        'children' => [
            [
                'title' => 'Trusted Car Expert',
                'route' => route('admin.content-meta.index', ['section' => 'trusted-car-expert']),
                'active' => Route::is('admin.content-meta.index')
                    && request()->segment(3) === 'trusted-car-expert',
            ],
            [
                'title' => 'How Autogenius Works',
                'route' => route('admin.content-meta.index', ['section' => 'how-autogenius-works']),
                'active' => Route::is('admin.content-meta.index')
                    && request()->segment(3) === 'how-autogenius-works',
            ],
            [
                'title' => 'Service Area',
                'route' => route('admin.content-meta.index', ['section' => 'service-area']),
                'active' => Route::is('admin.content-meta.index')
                    && request()->segment(3) === 'service-area',
            ],
            [
                'title' => 'Why Choose Autogenius',
                'route' => route('admin.content-meta.index', ['section' => 'why-choose-autogenius']),
                'active' => Route::is('admin.content-meta.index')
                    && request()->segment(3) === 'why-choose-autogenius',
            ],
            [
                'title' => 'Protecting Buyers',
                'route' => route('admin.content-meta.index', ['section' => 'protecting-buyers']),
                'active' => Route::is('admin.content-meta.index')
                    && request()->segment(3) === 'protecting-buyers',
            ],
            [
                'title' => 'About Autogenius',
                'route' => route('admin.content-meta.index', ['section' => 'about-autogenius']),
                'active' => Route::is('admin.content-meta.index')
                    && request()->segment(3) === 'about-autogenius',
            ],
            [
                'title' => 'Why We Found Autogenius',
                'route' => route('admin.content-meta.index', ['section' => 'why-we-founded-autogenius']),
                'active' => Route::is('admin.content-meta.index')
                    && request()->segment(3) === 'why-we-founded-autogenius',
            ],

        ],

        // Parent should be active if ANY child is active
        'active' => Route::is('admin.content-meta.index')
            && in_array(request()->segment(3), [
                'service-area',
                'trusted-car-expert',
                'why-choose-autogenius',
                'how-autogenius-works',
                'protecting-buyers',
                'about-autogenius',
                'why-we-founded-autogenius',
            ]),
    ],

    /* [
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
    ], */
    [
        'title' => 'Slider',
        'icon' => 'bi-journal-text',
        'children' => [
            [
                'title' => 'Slides',
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
        'title' => 'Content Management',
        'icon' => 'bi-folder',
        'children' => [
          /*   [
                'title' => 'Faqs',
                'route' => route('admin.faqs.index'),
                'active' => Route::is('admin.faqs.index'),
            ], */
            [
                'title' => 'Pages',
                'route' => route('admin.pages.index'),
                'active' => Route::is('admin.pages.index'),
            ],
            [
                'title' => 'Email Templates',

                'route' => route('admin.email-templates.index'),
                'active' => Route::is('admin.email-templates.index'),
            ],
        ],
        'active' => Route::is('admin.faqs.index') || Route::is('admin.pages.index') || Route::is('admin.email-templates.index'),
    ],
    [
        'title' => 'Settings',
        'icon' => 'bi-gear',
        'route' => route('admin.settings.index'),
        'active' => Route::is('admin.settings.index'),
    ],
];
