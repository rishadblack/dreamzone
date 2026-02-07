<?php
namespace App\Pages\Frontend;

use App\Http\Common\Component;
use App\Models\Product as ProductModel;
use Livewire\Attributes\Layout;

#[Layout('layouts.frontend')]
class Product extends Component
{
    public $product;

    protected $listeners = [
        'updateCartList' => '$refresh',
    ];

    public function mount($product_id)
    {
        $this->product = ProductModel::find($product_id);
    }

    public function render()
    {
        return view('pages.frontend.product', [
            'related_products' => ProductModel::where('category_id', $this->product->category_id)->where('id', '!==', $this->product->product_id)->limit(5)->get(),
        ]);
    }
}