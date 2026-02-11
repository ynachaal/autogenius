<?php

return [
    [
        'title' => 'Home',
        'route' => route('home'),
    ],
    [
        'title' => 'About Us',
        'route' => route('front.about'),
    ],
    [
        'title' => 'Services',
          'route' => route('services.index'),
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
