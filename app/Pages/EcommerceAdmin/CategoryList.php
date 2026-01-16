<?php

namespace App\Pages\EcommerceAdmin;

use App\Http\Common\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class CategoryList extends Component
{
    public $category_id;
    public $name;
    public $description;
    public $sort;
    public $image_url;
    public $icon;
    public $is_featured;
    public $status = 1;

    #[On('openCategoryModal')]
    public function openCategoryModal($data = null)
    {
        $this->reset();

        if (isset($data['id'])) {
            $this->editCategory($data['id']);
        }

        $this->dispatch('modalOpen', 'CategoryModal');
    }

    public function editCategory($id)
    {
        $Category = Category::find($id);
        if(!$Category) {
            $this->alert('error', 'Category not found');
            return;
        }

        $this->category_id = $Category->id;

        $this->name = $Category->name;
        $this->description = $Category->description;
        $this->sort = $Category->sort;
        $this->image_url = $Category->image_url;
        $this->icon = $Category->icon;
        $this->is_featured = $Category->is_featured;
        $this->status = $Category->status;



    }

    public function storeCategory()
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

        $Category = Category::findOrNew($this->category_id);

        if(!$this->category_id) {
            $Category->user_id = Auth::id();
            $message = 'Category created successfully';
        } else {
            $message = 'Category updated successfully';
        }

        $Category->name = $this->name;
        $Category->description = $this->description;
        $Category->sort = $this->sort;
        $Category->icon = $this->icon;
        $Category->is_featured = $this->is_featured;
        $Category->status = $this->status;
        $Category->save();


        $this->dispatch('modalClose', 'CategoryModal');
        $this->alert('success', 'Category saved successfully');
        $this->dispatch('refreshDatatable');

        $this->reset();
    }

    #[On('deleteCategory')]
    public function deleteCategory($data)
    {
        $data = $this->alertConfirm($data, 'Are you sure you want to delete this category?');

        if(isset($data['id'])) {
            $Category = Category::find($data['id']);


            if(!$Category) {
                $this->alert('error', 'Category not found');
                return;
            }

            $Category->delete();
            $this->alert('success', 'Category deleted successfully');
            $this->dispatch('refreshDatatable');

        }
    }

    public function render()
    {
        return view('pages.ecommerce-admin.category-list');
    }
}