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
  
];
