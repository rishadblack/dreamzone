<?php
namespace App\Pages\Frontend\Component;

use App\Models\Product;
use Livewire\Component;

class ProductCardComponent extends Component
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
        return view('pages.frontend.component.product-card-component', [
            'product' => Product::findOrFail($this->productId),
        ]);
    }
}