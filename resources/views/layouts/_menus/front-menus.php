<?php

use App\Services\ServiceService;

$serviceService = app(ServiceService::class);
$services = $serviceService->getActiveServices(); // only active services

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
        'submenu' => $services->map(fn($service) => [
            'title' => $service->title,  // assuming 'title' column exists
            'route' => route('services.show', $service->slug), // assuming 'slug' column exists
        ])->toArray(),
    ],
    [
        'title' => 'Car Deliveries',
        'route' => '', // update route if needed
    ],
    [
        'title' => 'Contact Us',
        'route' => route('frontend.contact.create'),
    ],
];
