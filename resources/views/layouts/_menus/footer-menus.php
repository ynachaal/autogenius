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
        'title' => ' Our Principles',
        'route' => route('pages.show', 'our-principles'),
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
