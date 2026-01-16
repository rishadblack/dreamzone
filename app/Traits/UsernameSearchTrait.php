<?php

namespace App\Traits;

use App\Models\User;

trait UsernameSearchTrait
{
    public $username_name;
    public $sponsor_username_name;
    public $placement_username_name;

    public function updatedUsername($value)
    {
        $this->resetValidation('username');
        $this->reset('username_name');

        $this->validateOnly('username', [
            'username' => ['string', 'min:4', 'exists:users,username'],
        ]);

        if (!empty($value)) {
            $User = User::select(['username', 'name'])->whereUsername($value)->first();

            if ($User) {
                if ($User->name != $this->username_name) {
                    $this->username_name = $User->name;
                }
            } else {
                $this->username_name = 'Invalid Username';
            }
        }
    }

    public function updatedSponsorUsername($value)
    {
        $this->resetValidation('sponsor_username');
        $this->reset('sponsor_username_name');

        $this->validateOnly('sponsor_username', [
            'sponsor_username' => ['string', 'min:4', 'max:50', 'alpha_dash', 'exists:users,username'],
        ]);

        if (!empty($value)) {
            $User = User::select(['username', 'name'])->whereUsername($value)->first();

            if ($User) {
                $this->sponsor_username_name = $User->name;
            } else {
                $this->sponsor_username_name = 'Invalid Sponsor Username';
            }
        }
    }

    public function updatedPlacementUsername($value)
    {
        $this->resetValidation('placement_username');
        $this->reset('placement_username_name');

        $this->validateOnly('placement_username', [
            'placement_username' => ['string', 'min:4', 'max:50', 'alpha_dash', 'exists:users,username'],
        ]);

        if (!empty($value)) {
            $User = User::select(['username', 'name'])->whereUsername($value)->first();

            if ($User) {
                $this->placement_username_name = $User->name;
            } else {
                $this->placement_username_name = 'Invalid Placement Username';
            }
        }
    }
}
