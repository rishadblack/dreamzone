<?php

namespace App\View\Components\Search;

use App\Models\Brand;
use Illuminate\View\Component;

class Brands extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.search.brands', [
            'brands' => Brand::active()->get(),
        ]);
    }
}
