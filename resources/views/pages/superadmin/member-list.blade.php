<div>
    <x-slot name="title"> Members </x-slot>
    <x-slot name="header"> Member List </x-slot>
    <x-card>
        <livewire:superadmin.datatable.member-table />
        <x-modal id="MemberModal" title="Member Profile Update" footer="button" size="lg">
            <h4>Personal Details</h4>
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="name" label="Name" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="email" label="Email" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="mobile" label="Mobile" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="address" label="Address" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="city" label="City" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="state" label="State" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.select wire:model="country_id" label="Country">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </x-input.select>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="post_code" label="Post Code" />
                </div>
            </div>
            <h4 class="pt-2">Access Details</h4>
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="username" label="Username" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="sponsor_username" label="Sponsor Username" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="password" label="Password" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="free_upgrade" label="Free Upgrade Account" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model="is_banned" label="Banned" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model="is_approve" label="Approved" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model="is_valid" label="Valid" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model="is_not_transferable" label="Not Transfer" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model="is_not_withdrawalable" label="Not Withdrawal" />
                </div>
            </div>
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storeMember"
                    wire:target="storeMember">Submit</x-button.default>
            </x-slot>
        </x-modal>
    </x-card>
</div>
