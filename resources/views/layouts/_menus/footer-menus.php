<?php

return [
    [
        'title' => 'Home',
        'route' => route('home'),
    ],
    [
        'title' => 'About Us',
        'route' => route('pages.show', 'about-us'),
    ],
    [
        'title' => 'Services',
          'route' => route('services.index'),
    ],
    [
        'title' => 'Blog',
        'route' => "javascript:void(0)",
    ],
    [
        'title' => 'Privacy Policy',
        'route' => route('pages.show', 'privacy-policy'),
    ],
    [
        'title' => 'Term and Conditions',
        'route' => route('pages.show', 'term-and-conditions'),
    ],
    [
        'title' => 'Contact us',
        'route' => route('frontend.contact.create'),
    ],
];
