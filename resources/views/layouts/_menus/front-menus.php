<?php

return [
    [
        'title' => 'Home',
        'route' => route('home'),
    ],
    [
        'title' => 'About Us',
        'route' => route('pages.show', 'about-us'), // assuming 'about-us' is the slug of your About page
    ],
    [
        'title' => 'Services',
        'route' => route('services.index'),
        'submenu' => [
            ['title' => 'New Car Consultation', 'route' => route('services.show', 'new-car-consultation')],
            ['title' => 'New Car PDI', 'route' => route('services.show', 'new-car-pdi')],
            ['title' => 'Used Car PDI / Checking / Testing', 'route' => route('services.show', 'used-car-testing')],
            ['title' => 'Used Car Consultation & Unlimited Testing', 'route' => route('services.show', 'used-car-consultation-testing')],
            ['title' => 'Car Servicing / Denting / Painting', 'route' => route('services.show', 'car-servicing-denting-painting')],
            ['title' => 'Car Accessories', 'route' => route('services.show', 'car-accessories')],
        ],
    ],
    [
        'title' => 'Car Deliveries',
        'route' => '', // assuming you have a blog route like Route::get('/blog', [BlogController::class, 'index'])->name('blog.index')
    ],
    [
        'title' => 'Contact Us',
        'route' => route('frontend.contact.create'),
    ],
];
