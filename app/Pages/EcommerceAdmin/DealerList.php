<?php
namespace App\Pages\EcommerceAdmin;

use App\Http\Common\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class DealerList extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $user_id;
    public $member_type;

    public $name;
    public $email;
    public $mobile;
    public $address;
    public $country_id = 19;
    public $division_id;
    public $district_id;
    public $upazila_id;
    public $post_code;

    public $business_name;
    public $business_email;
    public $business_mobile;
    public $business_address;
    public $business_country_id = 19;
    public $business_division_id;
    public $business_district_id;
    public $business_upazila_id;
    public $business_post_code;
    public $username;
    public $sponsor_username;
    public $password;
    public $is_banned;
    public $is_approve;
    public $is_not_transferable;
    public $is_not_withdrawalable;
    public $is_founder;
    public $is_office;

    #[On('openDealerModal')]
    public function openDealerModal($data = null)
    {
        $this->reset();

        if (isset($data['id'])) {
            $this->editDealer($data['id']);
        }

        $this->dispatch('modalOpen', 'DealerModal');

    }

    public function editDealer($id)
    {
        $User = User::with(['memberTree.bySponsor', 'Dealer'])->find($id);
        if ($User) {
            $this->user_id = $User->id;
            $this->name = $User->name;
            $this->username = $User->username;
            $this->email = $User->email;
            $this->mobile = $User->mobile;
            $this->address = $User->address;
            $this->division_id = $User->division_id;
            $this->district_id = $User->district_id;
            $this->upazila_id = $User->upazila_id;
            $this->country_id = $User->country_id;
            $this->post_code = $User->post_code;
            $this->is_banned = $User->is_banned ? true : null;
            $this->is_approve = $User->is_approve ? true : null;
            $this->is_not_transferable = $User->is_not_transferable ? true : null;
            $this->is_not_withdrawalable = $User->is_not_withdrawalable ? true : null;
            $this->sponsor_username = $User->memberTree->bySponsor ? $User->memberTree->bySponsor->username : null;

            $Dealer = $User->Dealer()->first();

            $this->business_name = $Dealer->business_name;
            $this->business_email = $Dealer->email;
            $this->business_mobile = $Dealer->mobile;
            $this->business_address = $Dealer->address;
            $this->business_post_code = $Dealer->post_code;
            $this->business_division_id = $Dealer->division_id;
            $this->business_district_id = $Dealer->district_id;
            $this->business_upazila_id = $Dealer->upazila_id;
            $this->business_country_id = $Dealer->country_id;
            $this->is_office = $Dealer->is_office ? true : null;
        }
    }

    public function storeDealer()
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

        $User = User::findOrNew($this->user_id);
        if ($this->user_id) {
            $messages = 'Dealer updated successfully';
        } else {
            $messages = 'Dealer registration successfully';
        }

        $User->name = $this->name;
        $User->username = $this->username;
        $User->email = $this->email;
        $User->mobile = $this->mobile;
        $User->address = $this->address;
        $User->division_id = $this->division_id;
        $User->district_id = $this->district_id;
        $User->upazila_id = $this->upazila_id;
        $User->country_id = $this->country_id;
        $User->post_code = $this->post_code;

        if ($this->is_banned) {
            $User->is_banned = $User->is_banned ? $User->is_banned : now();
        } elseif (! $this->is_banned) {
            $User->is_banned = null;
        }

        if ($this->is_approve) {
            $User->is_approve = $User->is_approve ? $User->is_approve : now();
        } elseif (! $this->is_approve) {
            $User->is_approve = null;
        }

        if ($this->is_not_transferable) {
            $User->is_not_transferable = $User->is_not_transferable ? $User->is_not_transferable : now();
        } elseif (! $this->is_not_transferable) {
            $User->is_not_transferable = null;
        }

        if ($this->is_not_withdrawalable) {
            $User->is_not_withdrawalable = $User->is_not_withdrawalable ? $User->is_not_withdrawalable : now();
        } elseif (! $this->is_not_withdrawalable) {
            $User->is_not_withdrawalable = null;
        }

        if ($this->password) {
            $User->password = Hash::make($this->password);
        }

        $User->save();

        $User->assignRole('dealer');

        $memberTree = $User->memberTree()->firstOrNew();
        $memberTree->sponsor_id = $this->sponsor_username ? $SponsorUser->id : null;
        $memberTree->save();

        $Dealer = $User->Dealer()->firstOrNew();
        $Dealer->business_name = $this->business_name;
        $Dealer->email = $this->business_email;
        $Dealer->mobile = $this->business_mobile;
        $Dealer->address = $this->business_address;
        $Dealer->division_id = $this->business_division_id;
        $Dealer->district_id = $this->business_district_id;
        $Dealer->upazila_id = $this->business_upazila_id;
        $Dealer->country_id = $this->business_country_id;
        $Dealer->post_code = $this->business_post_code;
        $Dealer->is_office = $this->is_office ? true : null;
        $Dealer->save();

        $this->dispatch('modalClose', 'DealerModal');
        $this->alert('success', $messages);
        $this->dispatch('refreshDatatable');
        $this->reset();
    }

    public function render()
    {
        return view('pages.ecommerce-admin.dealer-list');
    }
}