<?php

namespace App\Pages\Superadmin;

use App\Models\User;
use App\Models\Country;
use App\Models\Package;
use App\Http\Common\Component;
use App\Traits\UserTrait;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class MemberList extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $user_id;
    public $member_type;

    public $name;
    public $email;
    public $mobile;
    public $address;
    public $city;
    public $state;
    public $country_id;
    public $post_code;
    public $username;
    public $sponsor_username;
    public $password;
    public $is_banned;
    public $is_approve;
    public $is_not_transferable;
    public $is_not_withdrawalable;
    public $is_founder;
    public $free_upgrade;


    #[On('openMemberModal')]
    public function openMemberModal($data = null)
    {
        $this->reset();

        $User = User::find($data['id']);
        if ($User) {
            $this->dispatch('modalOpen', 'MemberModal');

            $this->user_id = $User->id;
            $this->name = $User->name;
            $this->username = $User->username;
            $this->email = $User->email;
            $this->mobile = $User->mobile;
            $this->address = $User->address;
            $this->city = $User->city;
            $this->state = $User->state;
            $this->country_id = $User->country_id;
            $this->post_code = $User->post_code;
            $this->is_banned = $User->is_banned ? true : null;
            $this->is_approve = $User->is_approve ? true : null;
            $this->is_not_transferable = $User->is_not_transferable ? true : null;
            $this->is_not_withdrawalable = $User->is_not_withdrawalable ? true : null;
            $this->is_founder = $User->memberTree->is_founder ? true : null;
            $this->free_upgrade = $User->free_upgrade;
            $this->sponsor_username = $User->memberTree->bySponsor ? $User->memberTree->bySponsor->username : null;
        }
    }

    public function storeMember()
    {
        $this->validate([
            'sponsor_username' => ['nullable', 'exists:users,username'],
            'username' => [
                'required',
                    function ($attribute, $value, $fail) {
                        if (User::where('id', '!=', $this->user_id)->whereUsername($value)->exists()) {
                            $fail('The ' . $attribute . ' is already exists.');
                        }
                    },
                ],
        ]);

        $SponsorUser = User::whereUsername($this->sponsor_username)->first();


        $User = User::find($this->user_id);
        $User->name = $this->name;
        $User->username = $this->username;
        $User->email = $this->email;
        $User->mobile = $this->mobile;
        $User->address = $this->address;
        $User->city = $this->city;
        $User->state = $this->state;
        $User->country_id = $this->country_id;
        $User->post_code = $this->post_code;

        if ($this->is_banned) {
            $User->is_banned = $User->is_banned ? $User->is_banned : now();
        } elseif (!$this->is_banned) {
            $User->is_banned = null;
        }

        if ($this->is_approve) {
            $User->is_approve = $User->is_approve ? $User->is_approve : now();
        } elseif (!$this->is_approve) {
            $User->is_approve = null;
        }

        if ($this->is_not_transferable) {
            $User->is_not_transferable = $User->is_not_transferable ? $User->is_not_transferable : now();
        } elseif (!$this->is_not_transferable) {
            $User->is_not_transferable = null;
        }

        if ($this->is_not_withdrawalable) {
            $User->is_not_withdrawalable = $User->is_not_withdrawalable ? $User->is_not_withdrawalable : now();
        } elseif (!$this->is_not_withdrawalable) {
            $User->is_not_withdrawalable = null;
        }

        if ($this->password) {
            $User->password = Hash::make($this->password);
        }

        $User->save();

        $User->memberTree->sponsor_id = $this->sponsor_username ? $SponsorUser->id : null;
        $User->memberTree->is_founder = $this->is_founder ? now() : null;
        $User->free_upgrade = $this->free_upgrade;
        $User->memberTree->save();

        $this->dispatch('modalClose', 'MemberModal');
        $this->alert('success', 'Member updated successfully');
        $this->dispatch('refreshDatatable');
        $this->reset();
    }

    public function render()
    {
        return view('pages.superadmin.member-list', [
            'countries' => Country::all(),
            'packages' => Package::active()->whereType(1)->get(),
        ]);
    }
}
