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
    'submenu' => [
        [
            'title' => 'New Car Consultation',
            'route' => route('services.show', 'new-car-consultation'),
        ],
        [
            'title' => 'Used Car Consultation & Unlimited Inspections',
            'route' => route('services.show', 'used-car-consultation-and-unlimited-inspections'),
        ],
        [
            'title' => 'Sell Your Car with AutoGenius',
            'route' => route('services.show', 'sell-your-car-with-autogenius'),
        ],
        [
            'title' => 'New Car Pdi',
            'route' => route('services.show', 'new-car-pdi'),
        ],
        [
            'title' => 'Used Car Inspection',
            'route' => route('services.show', 'used-car-inspection'),
        ],
        [
            'title' => 'Premium & Luxury Car Inspection',
            'route' => route('services.show', 'premium-luxury-car-inspection'),
        ],
        [
            'title' => 'Get Your Own Car Inspected',
            'route' => route('services.show', 'get-your-own-car-inspected'),
        ],
        [
            'title' => 'Get Service history and insurance claim details',
            'route' => route('services.show', 'get-service-history-and-insurance-claim-details'),
        ],
        [
            'title' => 'On Call Consultation',
            'route' => route('services.show', 'on-call-consultation'),
        ],
        [
            'title' => 'Insurance With AutoGenius',
            'route' => route('services.show', 'insurance-with-autogenius'),
        ],
    ],

    // Parent active if ANY service page OR admin services pages are active
    'active' => 
        Route::is('services.show') 
      
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
