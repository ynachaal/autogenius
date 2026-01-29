<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Collection;

class SliderCarousel extends Component
{
    public Collection $sliders;
    public string $carouselId;

    /**
     * Create a new component instance.
     */
    public function __construct(Collection $sliders, string $carouselId = 'carouselExample')
    {
        $this->sliders = $sliders;
        $this->carouselId = $carouselId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.slider-carousel');
    }
}
