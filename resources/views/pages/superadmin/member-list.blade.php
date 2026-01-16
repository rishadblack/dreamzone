<div>
    <x-slot name="title"> Members </x-slot>
    <x-slot name="header"> Member List </x-slot>
    <x-card>
        <livewire:superadmin.datatable.member-table />
        <x-modal id="MemberModal" title="Member Profile Update" footer="button" size="lg">
            <h4>Personal Details</h4>
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model.defer="name" label="Name" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model.defer="email" label="Email" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model.defer="mobile" label="Mobile" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model.defer="address" label="Address" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model.defer="city" label="City" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model.defer="state" label="State" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.select wire:model.defer="country_id" label="Country">
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </x-input.select>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model.defer="post_code" label="Post Code" />
                </div>
            </div>
            <h4 class="pt-2">Access Details</h4>
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model.defer="username" label="Username" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model.defer="sponsor_username" label="Sponsor Username" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model.defer="password" label="Password" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model.defer="free_upgrade" label="Free Upgrade Account" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model.defer="is_banned" label="Banned" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model.defer="is_approve" label="Verified" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model.defer="is_not_transferable" label="Not Transfer" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model.defer="is_not_withdrawalable" label="Not Withdrawal" />
                </div>
            </div>
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storeMember"
                    wire:target="storeMember">Submit</x-button.default>
            </x-slot>
        </x-modal>
    </x-card>
</div>
