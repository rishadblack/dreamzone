<?php

namespace App\Pages\Superadmin;

use App\Models\Dealer;
use App\Models\MemberTree;
use App\Models\User;
use App\Traits\UsernameSearchTrait;
use App\Traits\UserTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Common\Component;
use Livewire\WithFileUploads;

class DealerList extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use UserTrait;
    use UsernameSearchTrait;

    public $user_id;

    public $name;
    public $email;
    public $mobile;
    public $address;
    public $country_id;
    public $division_id;
    public $district_id;
    public $upazila_id;
    public $post_code;
    public $union;
    public $new_username;
    public $sponsor_username;
    public $password;
    public $is_banned;
    public $is_approve;
    public $is_not_transferable;
    public $is_not_withdrawalable;
    public $is_office;
    public $is_banned_cod;
    public $is_banned_balance;
    public $dealer_name;
    public $type;
    public $status;

    protected $listeners = [
        'openDealerModal',
    ];

    public function openDealerModal($data = null)
    {
        $this->dispatch('modalOpen', 'DealerModal');
        $this->reset();

        if ($data && isset($data['id'])) {
            $this->viewDealer($data['id']);
        }
    }

    public function viewDealer($id)
    {
        $User = User::findOrFail($id);
        $this->user_id = $User->id;
        $this->name = $User->name;
        $this->new_username = $User->username;
        $this->email = $User->email;
        $this->mobile = $User->mobile;
        $this->address = $User->address;
        $this->division_id = $User->division_id;
        $this->district_id = $User->district_id;
        $this->upazila_id = $User->upazila_id;
        $this->country_id = $User->country_id;
        $this->post_code = $User->post_code;
        $this->union = $User->union;
        $this->is_banned = $User->is_banned ? true : null;
        $this->is_approve = $User->is_approve ? true : null;
        $this->is_not_transferable = $User->is_not_transferable ? true : null;
        $this->is_not_withdrawalable = $User->is_not_withdrawalable ? true : null;
        $this->sponsor_username = $User->memberTree->bySponsor ? $User->memberTree->bySponsor->username : null;
        $this->is_office = $User->Dealer->is_office ? true : null;
        $this->is_banned_cod = $User->Dealer->is_banned_cod ? true : null;
        $this->is_banned_balance = $User->Dealer->is_banned_balance ? true : null;
        $this->dealer_name = $User->Dealer->dealer_name;
        $this->type = $User->Dealer->type;
        $this->status = $User->Dealer->status;
    }

    public function storeDealer()
    {
        $this->validate([
            'dealer_name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'integer', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'integer'],
            'division_id' => ['required', 'integer'],
            'district_id' => ['required', 'integer'],
            'upazila_id' => ['required', 'integer'],
            'post_code' => ['required', 'string', 'max:255'],
            'sponsor_username' => ['nullable', 'exists:users,username'],
            'new_username' => [
                'required',
                    function ($attribute, $value, $fail) {
                        if ($this->user_id) {
                            if (User::where('id', '!=', $this->user_id)->whereUsername($value)->exists()) {
                                $fail('The '.$attribute.' is already exists.');
                            }
                        } else {
                            if (User::whereUsername($value)->exists()) {
                                $fail('The '.$attribute.' is already exists.');
                            }
                        }
                    },
                ],
            'password' => ['nullable', Password::defaults()],
        ]);

        $User = User::findOrNew($this->user_id);
        $User->name = $this->name;
        $User->username = $this->new_username;
        $User->email = $this->email;
        $User->mobile = $this->mobile;
        $User->address = $this->address;
        $User->country_id = $this->country_id;
        $User->division_id = $this->division_id;
        $User->district_id = $this->district_id;
        $User->upazila_id = $this->upazila_id;
        $User->post_code = $this->post_code;
        $User->union = $this->union;

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

        $User->syncRoles(['dealer']);

        $MemberTree = MemberTree::whereUserId($User->id)->firstOrNew();
        $MemberTree->user_id = $User->id;
        $MemberTree->is_premium = now();
        $MemberTree->sponsor_id = $this->sponsor_username ? $this->getIdByUsername($this->sponsor_username) : null;
        $MemberTree->save();

        $Dealer = Dealer::whereUserId($User->id)->firstOrNew();
        $Dealer->user_id = $User->id;
        $Dealer->dealer_name = $this->dealer_name;
        $Dealer->type = $this->type;
        $Dealer->country_id = $this->country_id;
        $Dealer->division_id = $this->division_id;
        $Dealer->district_id = $this->district_id;
        $Dealer->upazila_id = $this->upazila_id;
        $Dealer->is_office = $this->is_office;
        $Dealer->is_banned_cod = $this->is_banned_cod;
        $Dealer->is_banned_balance = $this->is_banned_balance;
        $Dealer->status = $this->status;
        $Dealer->save();

        if ($Dealer->is_office) {
            $User->assignRole('manager');
        }

        $this->dispatch('modalClose', 'DealerModal');
        $this->alert('success', 'Member updated successfully');
        $this->dispatch('refreshdatatable');
        $this->reset();
    }

    public function render()
    {
        return view('pages.dealer-list')->layout('layouts.backend-layout');
    }
}
