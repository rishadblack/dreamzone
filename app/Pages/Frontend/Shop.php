<?php
namespace App\Pages\Frontend;

use App\Http\Common\Component;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.frontend')]
class Shop extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'refreshSearch',
    ];

    public array $categoryIds = [];
    public array $brandIds    = [];
    public $paginate_show     = 12;
    public $search;

    protected $queryString = ['paginate_show'];

    public function refreshSearch($search)
    {
        $this->search = $search;
    }

    public function mount()
    {
        $this->search = request()->query('search');

        if (request()->has('category_id')) {
            $this->categoryIds[] = request()->query('category_id');
        }

        if (request()->has('brand_id')) {
            $this->brandIds[] = request()->query('brand_id');
        }
    }

    public function render()
    {
        $products = Product::active();

        if (count($this->categoryIds) > 0) {
            $products->whereIn('category_id', $this->categoryIds);
        }

        if (count($this->brandIds) > 0) {
            $products->whereIn('brand_id', $this->brandIds);
        }

        if ($this->search) {
            $products->search($this->search);
        }

        return view('pages.frontend.shop', [
            'categories' => Category::withCount('Products')->active()->get(),
            'brands' => Brand::withCount('Products')->active()->get(),
            'products' => $products->paginate($this->paginate_show),
        ]);
    }
}