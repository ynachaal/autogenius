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
        'route' => route('user.dashboard'),
        'active' => Route::is('user.dashboard'),
    ],
    [
        'title' => 'Properties',
        'icon' => 'bi-building',
        'route' => route('user.properties.index'),
        'active' => Route::is('user.properties.*'),
    ],
     [
        'title' => 'Developer Partners',
        'icon' => 'bi-house',
        'route' => route('user.developer-partners.index'),
        'active' => Route::is('user.developer-partners.*'),
    ],
    // [
    //     'title' => 'Properties',
    //     'icon' => 'bi-building',
    //     'children' => [
    //         [
    //             'title' => 'Properties',
    //             'route' => route('user.properties.index'),
    //             'active' => Route::is('user.properties.*'),
    //         ],
    //         [
    //             'title' => 'Property Areas',
    //             'route' => route('user.property-areas.index'),
    //             'active' => Route::is('user.property-areas.*'),
    //         ],
    //         [
    //             'title' => 'Property Types',
    //             'route' => route('user.property-types.index'),
    //             'active' => Route::is('user.property-types.*'),
    //         ],
    //     ],
    //     'active' => Route::is('user.properties.*') || Route::is('user.property-areas.*') || Route::is('user.property-types.*'),
    // ],
];
