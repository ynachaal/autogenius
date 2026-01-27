<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BrandSwiper extends Component
{
    public $brands;

    /**
     * Create a new component instance.
     *
     * @param $brands
     */
    public function __construct($brands)
    {
        $this->brands = $brands;
    }

    public function render()
    {
        return view('components.brand-swiper');
    }
}
