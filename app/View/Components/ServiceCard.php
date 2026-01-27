<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ServiceCard extends Component
{
    public $service;
    public $delay;

    public function __construct($service, $delay = 0)
    {
        $this->service = $service;
        $this->delay = $delay;
    }

    public function render()
    {
        return view('components.service-card');
    }
}
