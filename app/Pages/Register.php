<?php

namespace App\Pages;

use App\Models\User;
use App\Models\Country;
use App\Jobs\ProcessSms;
use App\Models\MemberTree;
use Illuminate\Support\Str;
use App\Http\Common\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterConfirmationMail;

#[Layout('layouts.auth')]
class Register extends Component
{
    public $name;
    public $mobile;
    public $email;
    public $username;
    public $sponsor_username;
    public $pin;
    public $country_id;
    public $mobile_code;
    public $country_code;
    public $password;
    public $password_confirmation;

    public function register()
    {
        $this->username = str_pad(substr(time(), -4).str_pad((User::latest()->orderByDesc('id')->first()?->id + 1), 3, '0', STR_PAD_LEFT), 8, '0', STR_PAD_LEFT);
        $this->pin = substr(time(), -4);

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255','unique:users,email'],
            'mobile' => ['required', 'string','min:11', 'max:11'],
            'sponsor_username' => ['required', 'exists:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'max:255'],
        ]);

        $sponsor = User::where('username', $this->sponsor_username)->first();

        if (!$sponsor) {
            $this->addError('sponsor_username', 'Sponsor not found.');

            return true;
        }

        try {
            DB::beginTransaction();

            $User = User::create([
                'uuid' => (string) Str::orderedUuid(),
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'country_id' => $this->country_id,
                'pin' => $this->pin,
                'password' => $this->password,
            ]);

            MemberTree::create([
                'user_id' => $User->id,
                'sponsor_id' => $sponsor->id,
            ]);

            $User->assignRole('user');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->alert('error', 'System Error. Please contact Administrator.');

            return true;
        }

        if ($User->email && app()->environment('production')) {
            // Mail::to($User->email)->queue(new RegisterConfirmationMail($User, $this->password));
        }


        if ($User->mobile && config('sms.signup_msg')) {
            ProcessSms::dispatchSync($User->mobile, config('sms.signup_msg').' ID: '.$this->username.' PW: '.$this->password, 'signup');
        }


        $this->reset();

        $this->alert('success', 'Your account has been created successfully.Try to login now.');
    }

    public function mount($ref = null)
    {
        $this->sponsor_username = $ref;
    }

    public function updatedCountryId()
    {
        $country = Country::find($this->country_id);
        if(!$country) {
            return;
        }
        $this->mobile_code = $country->phonecode;
        $this->country_code = $country->iso2;

    }

    public function render()
    {
        return view('pages.register', [
            'countries' => Country::all(),
        ]);
    }
}
