<?php

// Note: The routes are based on the standard naming conventions inferred from
// the admin config and the single 'Contact' route provided in the HTML.
// Placeholders are used for routes that linked to 'javascript:void(0)'.

return [
    [
        'title' => 'Home',
        'route' =>"javascript:void(0)", // Inferred/Placeholder
    ],
    [
        'title' => 'About Us',
        'route' => "javascript:void(0)", // Inferred/Placeholder
    ],
    [
        'title' => 'Services',
        'route' => "javascript:void(0)", // Inferred/Placeholder
        'submenu' => [
            [ 'title' => 'New Car Consultation', 'route' => "javascript:void(0)" ],
            [ 'title' => 'New Car PDI', 'route' => "javascript:void(0)" ],
            [ 'title' => 'Used Car PDI / Checking / Testing', 'route' => "javascript:void(0)" ],
            [ 'title' => 'Used Car Consultation & Unlimited Testing', 'route' => "javascript:void(0)" ],
            [ 'title' => 'Car Servicing / Denting / Painting', 'route' => "javascript:void(0)" ],
            [ 'title' => 'Car Accessories', 'route' => "javascript:void(0)" ],
        ]
    ],
    [
        'title' => 'Reviews',
        'route' => "javascript:void(0)", // Inferred/Placeholder
    ],
    [
        'title' => 'Blog',
        'route' => "javascript:void(0)", // Inferred/Placeholder
    ],
    [
        'title' => 'Contact Us',
        'route' => "javascript:void(0)", // Inferred/Placeholder
    ],
];
