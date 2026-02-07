<?php
namespace App\Pages\EcommerceAdmin;

use App\Http\Common\Component;
use App\Models\Slider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class SliderList extends Component
{
    use WithFileUploads;

    public $slider_id;
    public $tag;
    public $title;
    public $sub_title;
    public $short_description;
    public $sort;
    public $image_url;
    public $image_url_preview;
    public $thumb_url;
    public $thumb_url_preview;
    public $link;
    public $status = 1;

    #[On('openSliderModal')]
    public function openSliderModal($data = null)
    {
        $this->reset();

        if (isset($data['id'])) {
            $this->editSlider($data['id']);
        }

        $this->dispatch('modalOpen', 'SliderModal');
    }

    public function editSlider($id)
    {
        $Slider = Slider::find($id);
        if (! $Slider) {
            $this->alert('error', 'Slider not found');
            return;
        }

        $this->slider_id = $Slider->id;

        $this->tag = $Slider->tag;
        $this->title = $Slider->title;
        $this->sub_title = $Slider->sub_title;
        $this->short_description = $Slider->short_description;
        $this->sort = $Slider->sort;
        $this->image_url_preview = $Slider->image_url;
        $this->thumb_url_preview = $Slider->thumb_url;
        $this->link = $Slider->link;
        $this->status = $Slider->status;

    }

    public function storeSlider()
    {
        $this->validate([
            'tag' => 'required|string',
            'title' => 'nullable|string',
            'sort' => 'nullable|numeric',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'thumb_url' => 'nullable|string',
            'link' => 'nullable|boolean',
            'status' => 'nullable|integer',
        ]);

        $Slider = Slider::findOrNew($this->slider_id);

        if (! $this->slider_id) {
            $Slider->user_id = Auth::id();
            $message = 'Slider created successfully';
        } else {
            $message = 'Slider updated successfully';
        }

        if ($this->image_url) {
            if ($Slider->image_url) {
                if (Storage::disk('public')->exists($Slider->image_url)) {
                    Storage::disk('public')->delete($Slider->image_url);
                }
            }

            $Slider->image_url = $this->image_url->store('gallery/slider', 'public');
        }

        if ($this->thumb_url) {
            if ($Slider->thumb_url) {
                if (Storage::disk('public')->exists($Slider->thumb_url)) {
                    Storage::disk('public')->delete($Slider->thumb_url);
                }
            }

            $Slider->thumb_url = $this->thumb_url->store('gallery/slider-thumb', 'public');
        }

        $Slider->tag = $this->tag;
        $Slider->title = $this->title;
        $Slider->sort = $this->sort;
        $Slider->thumb_url = $this->thumb_url;
        $Slider->link = $this->link;
        $Slider->status = $this->status;
        $Slider->save();

        $this->dispatch('modalClose', 'SliderModal');
        $this->alert('success', $message);
        $this->dispatch('refreshDatatable');

        $this->reset();
    }

    #[On('deleteSlider')]
    public function deleteSlider($data)
    {
        $data = $this->alertConfirm($data, 'Are you sure you want to delete this category?');

        if (isset($data['id'])) {
            $Slider = Slider::find($data['id']);

            if (! $Slider) {
                $this->alert('error', 'Slider not found');
                return;
            }

            $Slider->delete();
            $this->alert('success', 'Slider deleted successfully');
            $this->dispatch('refreshDatatable');

        }
    }

    public function render()
    {
        return view('pages.ecommerce-admin.slider-list');
    }
}