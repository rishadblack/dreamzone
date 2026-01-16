<?php

namespace App\Pages\Backend;

use App\Models\Country;
use App\Http\Common\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Profile extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $name;
    public $profile_image;
    public $profile_image_preview;
    public $email;
    public $mobile;
    public $address;
    public $city;
    public $post_code;
    public $state;
    public $country_id;

    public $current_password;
    public $password;
    public $password_confirmation;

    public function storePasswordChange()
    {
        $this->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (Hash::check($this->current_password, Auth::User()->password)) {
            $user = Auth::User();
            $user->password = Hash::make($this->password);
            $user->save();
        } else {
            $this->addError('current_password', 'Current password is wrong please try again..');

            return true;
        }

        $this->reset([
            'current_password',
            'password',
            'password_confirmation',
        ]);

        $this->alert('success', 'Your new password updated successfully');
    }

    public function storeProfileUpdate()
    {
        $this->validate([
            'profile_image' => ['nullable', 'image', 'max:1024'],
            'email' => ['nullable', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'post_code' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country_id' => ['required'],
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
        $User->email = $this->email;
        $User->mobile = $this->mobile;
        $User->address = $this->address;
        $User->city = $this->city;
        $User->post_code = $this->post_code;
        $User->state = $this->state;
        $User->country_id = $this->country_id;
        $User->save();

        $this->alert('success', 'Your profile updated successfully');
    }

    public function mount()
    {
        $User = Auth::User();
        $this->name = $User->name;
        $this->profile_image_preview = $User->profile;
        $this->email = $User->email;
        $this->mobile = $User->mobile;
        $this->address = $User->address;
        $this->city = $User->city;
        $this->post_code = $User->post_code;
        $this->state = $User->state;
        $this->country_id = $User->country_id;
    }

    public function render()
    {
        return view('pages.backend.profile', [
            'countries' => Country::all(),
        ]);
    }
}
