<div>
    <x-slot name="title"> Dealers </x-slot>
    <x-slot name="header"> Dealer List </x-slot>
    <x-card>
        <div>
            <button type="button" class="btn btn-success float-end mt-0 mb-2 ms-2" wire:click="openDealerModal">
                <em class="fa fa-plus me-1"></em><span>Dealer Register</span>
            </button>
        </div>

        <livewire:ecommerce-admin.datatable.dealer-table />

        <x-modal id="DealerModal" :title="$user_id ? 'Dealer Information Update' : 'Dealer Registration'" footer="button" size="lg">
            <h4>Personal Details</h4>
            <div class="row" wire:key="personal">
                <div class="col-sm-6 col-lg-4">
                    <x-input.select wire:model="type" label="Type" :options="collect(config('status.dealer_type'))->where('value', '!=', 'office')" />
                </div>
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
                    <x-input.text wire:model="post_code" label="Post Code" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-search.divisions wire:model.live="division_id" :country_id="$country_id" label="Division" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-search.districts wire:model.live="district_id" :division_id="$division_id" label="District" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-search.upazilas wire:model.live="upazila_id" :district_id="$district_id" label="Upazila" />
                </div>
            </div>
            <h4>Company Details</h4>
            <div class="row" wire:key="company">
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="business_name" label="Business Name" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="business_email" label="Business Email" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="business_mobile" label="Business Mobile" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="business_address" label="Business Address" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="business_post_code" label="Business Post Code" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-search.divisions wire:model.live="business_division_id" :country_id="$business_country_id"
                        label="Business Division" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-search.districts wire:model.live="business_district_id" :division_id="$business_division_id"
                        label="Business District" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-search.upazilas wire:model.live="business_upazila_id" :district_id="$business_district_id"
                        label="Business Upazila" />
                </div>
            </div>
            <h4 class="pt-2">Access Details</h4>
            <div class="row" wire:key="access">
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="username" label="Username" />
                </div>
                {{-- <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="sponsor_username" label="Sponsor Username" />
                </div> --}}
                <div class="col-sm-6 col-lg-4">
                    <x-input.text wire:model="password" label="Password" />
                </div>
            </div>
            <div class="row" wire:key="access-check">
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model="is_office" label="Own Office" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model="is_banned" label="Banned" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model="is_not_transferable" label="Not Transfer" />
                </div>
                <div class="col-sm-6 col-lg-4">
                    <x-input.checkbox wire:model="is_not_withdrawalable" label="Not Withdrawal" />
                </div>
            </div>
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storeDealer"
                    wire:target="storeDealer">Submit</x-button.default>
            </x-slot>
        </x-modal>
    </x-card>
</div>
