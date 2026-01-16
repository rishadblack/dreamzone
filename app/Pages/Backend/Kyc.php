<?php

namespace App\Pages\Backend;

use App\Models\Country;
use App\Http\Common\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Kyc extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $name;
    public $profile_image;
    public $profile_image_preview;
    public $national_id;
    public $national_id_image;
    public $national_id_image_preview;
    public $birth;
    public $email;
    public $mobile;
    public $address;
    public $city;
    public $post_code;
    public $state;
    public $country_id;
    public $describe;
    public $all_checked;

    public function storeVerify()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'profile_image' => ['nullable', 'image', 'max:1024'],
            'national_id' => ['required', 'string', 'max:50'],
            'national_id_image' => ['nullable', 'image', 'max:1024'],
            'birth' => ['required', 'string'],
            'email' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'post_code' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country_id' => ['required'],
            'all_checked' => ['required'],
        ]);

        $User = Auth::User();

        if ($this->profile_image) {
            if ($User->profile) {
                if (Storage::disk('public')->exists($User->profile)) {
                    Storage::disk('public')->delete($User->profile);
                }
            }
            $User->profile = $this->profile_image->store('gallery/profile', 'public');
        }

        if ($this->national_id_image) {
            if ($User->national_id_image) {
                if (Storage::disk('public')->exists($User->national_id_image)) {
                    Storage::disk('public')->delete($User->national_id_image);
                }
            }
            $User->national_id_image = $this->national_id_image->store('gallery/profile', 'public');
        }

        $User->name = $this->name;
        $User->national_id = $this->national_id;
        $User->birth = $this->birth;
        $User->email = $this->email;
        $User->mobile = $this->mobile;
        $User->address = $this->address;
        $User->city = $this->city;
        $User->post_code = $this->post_code;
        $User->state = $this->state;
        $User->country_id = $this->country_id;
        $User->is_agree = now();
        $User->save();

        $this->alert('success', 'Your varification info is submitted. We are review as soon as possible');
    }

    public function mount()
    {
        $User = Auth::User();
        $this->name = $User->name;
        $this->profile_image_preview = $User->profile ? Storage::disk('public')->url($User->profile) : $User->profile_url;
        $this->national_id = $User->national_id;
        $this->national_id_image_preview = Storage::disk('public')->url($User->national_id_image);
        $this->birth = $User->birth ? $User->birth->format(getTimeFormat()) : null;
        $this->email = $User->email;
        $this->mobile = $User->mobile;
        $this->address = $User->address;
        $this->city = $User->city;
        $this->post_code = $User->post_code;
        $this->state = $User->state;
        $this->country_id = $User->country_id;
        $this->all_checked = $User->is_agree ? true : null;
    }

    public function render()
    {
        return view('pages.backend.kyc', [
            'countries' => Country::all(),
        ]);
    }
}
