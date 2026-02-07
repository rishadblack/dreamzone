<?php
namespace App\Pages\Frontend;

use App\Http\Common\Component;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Livewire\Attributes\Layout;

#[Layout('layouts.frontend')]
class Home extends Component
{
    public function render()
    {
        return view('pages.frontend.home', [
            'categories' => Category::active()->get(),
            'featured_categories' => Category::with('limitProducts')->active()->featured()->get(),
            'brands' => Brand::active()->get(),
            'home_slides' => Slider::active()->whereTag('main_slider')->get(),
            'home_banners' => Slider::active()->whereTag('home_banner')->get(),
            'featured_products' => Product::active()->featured()->limit(20)->get(),
        ]);
    }
}