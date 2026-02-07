<?php
namespace App\Pages\Frontend\Component;

use App\Models\Product;
use Livewire\Component;

class ProductFeaturedComponent extends Component
{
    protected $listeners = [
        'updateCartList' => '$refresh',
    ];

    public $productId;

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function render()
    {
        return view('pages.frontend.component.product-featured-component', [
            'product' => Product::findOrFail($this->productId),
        ]);
    }
}