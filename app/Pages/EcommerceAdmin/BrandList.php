<?php

namespace App\Pages\EcommerceAdmin;

use App\Models\Brand;
use App\Http\Common\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class BrandList extends Component
{
    public $brand_id;
    public $name;
    public $description;
    public $sort;
    public $image_url;
    public $icon;
    public $is_featured;
    public $status = 1;

    #[On('openBrandModal')]
    public function openBrandModal($data = null)
    {
        $this->reset();

        if (isset($data['id'])) {
            $this->editBrand($data['id']);
        }

        $this->dispatch('modalOpen', 'BrandModal');
    }

    public function editBrand($id)
    {
        $Brand = Brand::find($id);
        if(!$Brand) {
            $this->alert('error', 'Brand not found');
            return;
        }

        $this->brand_id = $Brand->id;

        $this->name = $Brand->name;
        $this->description = $Brand->description;
        $this->sort = $Brand->sort;
        $this->image_url = $Brand->image_url;
        $this->icon = $Brand->icon;
        $this->is_featured = $Brand->is_featured;
        $this->status = $Brand->status;



    }

    public function storeBrand()
    {
        $this->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'sort' => 'nullable|numeric',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'icon' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'status' => 'nullable|integer',
        ]);

        $Brand = Brand::findOrNew($this->brand_id);

        if(!$this->brand_id) {
            $Brand->user_id = Auth::id();
            $message = 'Brand created successfully';
        } else {
            $message = 'Brand updated successfully';
        }

        $Brand->name = $this->name;
        $Brand->description = $this->description;
        $Brand->sort = $this->sort;
        $Brand->icon = $this->icon;
        $Brand->is_featured = $this->is_featured;
        $Brand->status = $this->status;
        $Brand->save();


        $this->dispatch('modalClose', 'BrandModal');
        $this->alert('success', 'Brand saved successfully');
        $this->dispatch('refreshDatatable');

        $this->reset();
    }

    #[On('deleteBrand')]
    public function deleteBrand($data)
    {
        $data = $this->alertConfirm($data, 'Are you sure you want to delete this category?');

        if(isset($data['id'])) {
            $Brand = Brand::find($data['id']);


            if(!$Brand) {
                $this->alert('error', 'Brand not found');
                return;
            }

            $Brand->delete();
            $this->alert('success', 'Brand deleted successfully');
            $this->dispatch('refreshDatatable');

        }
    }

    public function render()
    {
        return view('pages.ecommerce-admin.brand-list');
    }
}
