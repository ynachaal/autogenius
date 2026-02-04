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
    'submenu' => collect([
        [
            'title' => 'Smart Car Requirements',
            'route' => route('lead.index'), // make sure this route exists
        ],
    ])->merge(
        $services
            ->where('slug', '!=', 'autogenius-merchandise')
            ->map(fn($service) => [
                'title' => $service->title,
                'route' => route('services.show', $service->slug),
            ])
    )->values()->toArray(),
],
    
    [
        'title' => 'Car Deliveries',
        'route' =>  route('car.deliveries'), // update route if needed
    ],
    [
        'title' => 'Contact Us',
        'route' => route('frontend.contact.create'),
    ],
    [
        'title' => 'Autogenius Merchandise',
        'route' => route('services.show', 'autogenius-merchandise'),
    ],
];
