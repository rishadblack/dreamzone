<?php
namespace App\Pages\EcommerceAdmin;

use App\Http\Common\Component;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class ProductList extends Component
{
    use WithFileUploads;

    public $product_id;

    public $brand_id;
    public $category_id;
    public $code;
    public $type;
    public $name;
    public $short_description;
    public $description;
    public $sort;
    public $title;
    public $point;
    public $price;
    public $vat;
    public $vat_amount;
    public $discount;
    public $discount_amount;
    public $net_price;
    public $is_featured;
    public $product_images;
    public $product_image_urls;
    public $status = 1;

    #[On('openProductModal')]
    public function openProductModal($data = null)
    {
        $this->productReset();

        if (isset($data['id'])) {
            $this->editProduct($data['id']);
        }

        $this->dispatch('modalOpen', 'ProductModal');
    }

    public function editProduct($id)
    {
        $Product = Product::find($id);
        if (! $Product) {
            $this->alert('error', 'Product not found');
            return;
        }

        $this->product_id = $Product->id;

        $this->brand_id = $Product->brand_id;
        $this->category_id = $Product->category_id;
        $this->code = $Product->code;
        $this->type = $Product->type;
        $this->name = $Product->name;
        $this->short_description = $Product->short_description;
        $this->description = $Product->description;
        $this->sort = $Product->sort;
        $this->title = $Product->title;
        $this->point = $Product->point;
        $this->price = numberFormat($Product->price);
        $this->discount = $Product->discount ? numberFormatOrPercent($Product->discount) : null;
        $this->discount_amount = numberFormat($Product->discount_amount);
        $this->vat = $Product->vat ? numberFormatOrPercent($Product->vat) : null;
        $this->vat_amount = numberFormat($Product->vat_amount);
        $this->net_price = numberFormat($Product->net_price);
        $this->status = $Product->status;
        $this->is_featured = $Product->is_featured ? true : null;
        $this->product_image_urls = $Product->Images;
    }

    public function storeProduct()
    {
        $this->validate([
            'name' => 'required|string',
            'code' => 'required|string',
            'brand_id' => 'required|integer',
            'category_id' => 'required|integer',
            'point' => 'required|numeric',
            'price' => 'required|numeric|min:1',
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);

        $Product = Product::findOrNew($this->product_id);

        if (! $this->product_id) {
            $Product->user_id = Auth::id();
            $message = 'Product created successfully';
        } else {
            $message = 'Product updated successfully';
        }

        $Product->brand_id = $this->brand_id;
        $Product->category_id = $this->category_id;
        $Product->name = $this->name;
        $Product->code = $this->code;
        $Product->short_description = $this->short_description;
        $Product->description = $this->description;
        $Product->point = $this->point;
        $Product->price = $this->price;
        $Product->discount = $this->discount;
        $Product->discount_amount = $this->discount_amount;
        $Product->vat = $this->vat;
        $Product->vat_amount = $this->vat_amount;
        $Product->net_price = $this->net_price;
        $Product->status = $this->status;
        $Product->is_featured = $this->is_featured ? true : null;
        $Product->save();

        if ($this->product_images && collect($this->product_images)->count() > 0) {
            foreach ($this->product_images as $product_image) {
                $ProductImage = new ProductImage();
                $ProductImage->user_id = Auth::id();
                $ProductImage->image_url = $product_image->store('gallery/product', 'public');
                $ProductImage->is_default = null;
                $ProductImage->product_id = $Product->id;
                $ProductImage->status = $this->status;
                $ProductImage->save();

                if (! ProductImage::where('product_id', $Product->id)->default()->exists()) {
                    $ProductImage->is_default = true;
                    $ProductImage->save();
                }
            }
        }

        $this->dispatch('modalClose', 'ProductModal');
        $this->alert('success', $message);
        $this->dispatch('refreshDatatable');

        $this->reset();
    }

    #[On('deleteProduct')]
    public function deleteProduct($data)
    {
        $data = $this->alertConfirm($data, 'Are you sure you want to delete this category?');

        if (isset($data['id'])) {
            $Product = Product::find($data['id']);

            if (! $Product) {
                $this->alert('error', 'Product not found');
                return;
            }

            $Product->delete();
            $this->alert('success', 'Product deleted successfully');
            $this->dispatch('refreshDatatable');

        }
    }

    public function productReset()
    {
        $this->reset();
        $this->resetValidation();
        $this->code = str_pad((Product::latest()->orderByDesc('id')->first()?->code + 1), 3, '0', STR_PAD_LEFT);
    }

    public function updatedPrice()
    {
        $this->productPriceUpdate();
    }

    public function updatedDiscount()
    {
        $this->productPriceUpdate();
    }

    public function updatedVat()
    {
        $this->productPriceUpdate();
    }

    public function productPriceUpdate()
    {
        $salePriceTotal = $this->price ? $this->price : 0;
        $discountTotal = $this->discount ? $this->discount : 0;
        $vatTotal = $this->vat ? $this->vat : 0;

        $totalPrice = $salePriceTotal;

        // Vat Cal

        if ($vatTotal > 0) {
            if (strpos($vatTotal, '%')) {
                $this->vat_amount = getPercentOfValue($vatTotal, $salePriceTotal);
            } else {
                $this->vat_amount = $vatTotal;
            }
        } else {
            $this->vat_amount = 0;
        }

        $totalPrice = $totalPrice + $this->vat_amount;

        //Discount Cal

        if ($discountTotal > 0) {
            if (strpos($discountTotal, '%')) {
                $this->discount_amount = getPercentOfValue($discountTotal, $salePriceTotal);
            } else {
                $this->discount_amount = $discountTotal;
            }
        } else {
            $this->discount_amount = 0;
        }

        $totalPrice = $totalPrice - $this->discount_amount;

        //net Sale Price

        if ($totalPrice > 0) {
            $this->net_price = numberFormat($totalPrice);
        } else {
            $this->net_price = null;
        }
    }

    public function productImageSetDefault($id)
    {
        ProductImage::whereProductId($this->product_id)->update(['is_default' => null]);
        ProductImage::whereProductId($this->product_id)->find($id)->update(['is_default' => true]);

        $this->product_image_urls = Product::find($this->product_id)->Images;

        $this->alert('success', 'Image Set Default Successfully');
    }

    public function productImageDelete($id)
    {
        $ProductImage = ProductImage::whereProductId($this->product_id)->find($id);

        if ($ProductImage->is_default) {
            $this->dispatchBrowserEvent('error', [
                'text' => 'Current image is default image. Change default image then try again',
            ]);

            return true;
        }

        if ($ProductImage->image_url) {
            if (Storage::disk('public')->exists($ProductImage->image_url)) {
                Storage::disk('public')->delete($ProductImage->image_url);
            }
        }

        $ProductImage->delete();

        $this->product_image_urls = Product::find($this->product_id)->Images;

        $this->alert('success', 'Image Deleted Successfully');
    }

    public function render()
    {
        return view('pages.ecommerce-admin.product-list');
    }
}