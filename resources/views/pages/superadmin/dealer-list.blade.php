<div>
    <x-slot name="title"> {{ config('mlm.dealer_name') }} </x-slot>
    <x-slot name="card_title"> {{ config('mlm.dealer_name') }} </x-slot>
    <x-slot name="card_sub_title"> All {{ config('mlm.dealer_name') }} List</x-slot>
    <x-slot name="card_short_des">
        <p>Here is the list of your all {{ config('mlm.dealer_name') }}!</p>
    </x-slot>
    <x-slot name="card_action">
        <ul class="nk-block-tools gx-3">
            <li><button type="button" class="btn btn-primary" x-data
                    @click="$dispatch('eventCallFunc',{callName:'openDealerModal'})"><span>New
                        {{ config('mlm.dealer_name') }}</span> <em class="icon ni ni-arrow-long-right"></em></button>
            </li>
        </ul>
    </x-slot>

    <div wire:ignore class="table-responsive">
        <table id="reportTable" class="table"></table>
    </div>

    <x-modal id="DealerModal" title="{{ config('mlm.dealer_name') }} Profile Update" footer="button" size="xl">
        <h4>{{ config('mlm.dealer_name') }} Personal Details</h4>
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
                <x-search.countries wire:model="country_id" label="Country" />
            </div>
            <div class="col-sm-6 col-lg-4">
                <x-search.divisions wire:model="division_id" :countryId="$country_id" label="Division" />
            </div>
            <div class="col-sm-6 col-lg-4">
                <x-search.districts wire:model="district_id" :divisionId="$division_id" label="District" />
            </div>
            <div class="col-sm-6 col-lg-4">
                <x-search.upazilas wire:model="upazila_id" :districtId="$district_id" label="Thana" />
            </div>
            <div class="col-sm-6 col-lg-4">
                <x-input.text wire:model.defer="post_code" label="Post Code" />
            </div>
        </div>
        <h4 class="pt-2">{{ config('mlm.dealer_name') }} Access Details</h4>
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <x-input.text wire:model="new_username" label="Username" />
            </div>
            <div class="col-sm-6 col-lg-4">
                <x-input.username wire:model="sponsor_username" :sponsor_username_name="$sponsor_username_name" label="Sponsor Username" />
            </div>
            <div class="col-sm-6 col-lg-4">
                <x-input.text wire:model.defer="password" label="Password" />
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
        <h4 class="pt-2">{{ config('mlm.dealer_name') }} Management</h4>
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <x-input.text wire:model.defer="dealer_name" label="Company Name" />
            </div>
            <div class="col-sm-6 col-lg-4">
                <x-input.select wire:model.defer="type" label="{{ config('mlm.dealer_name') }} Type"
                    :options="config('status.dealer_type')" />
            </div>
            <div class="col-sm-6 col-lg-4">
                <x-input.select wire:model.defer="status" label="{{ config('mlm.dealer_name') }} Status"
                    :options="config('status.common_status')" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <x-input.checkbox wire:model.defer="is_office" label="Is Office" />
            </div>
            <div class="col-sm-6 col-lg-4">
                <x-input.checkbox wire:model.defer="is_banned_cod" label="Banned COD Order" />
            </div>
            <div class="col-sm-6 col-lg-4">
                <x-input.checkbox wire:model.defer="is_banned_balance" label="Banned Fund Order" />
            </div>
        </div>
        <x-slot name="footer">
            <x-button.default class="btn btn-success" type="button" wire:click="storeDealer" wire:target="storeDealer">
                Submit</x-button.default>
        </x-slot>
    </x-modal>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            window.loadDataTable = loadDatatable('#reportTable', {
                ajax: "{{ route('superadmin.datatable', ['table' => 'dealerListDatatable']) }}",
                columns: [{
                        title: 'ID',
                        data: 'id'
                    },
                    {
                        title: 'Name',
                        name: 'name',
                        data: 'name'
                    },
                    {
                        title: 'Username',
                        name: 'username',
                        data: 'username'
                    },
                    {
                        title: 'Current Shopping Balance',
                        name: 'current_balance',
                        data: 'current_balance',
                        searchable: false
                    },
                    {
                        title: 'Registered',
                        name: 'created_at',
                        data: 'created_at',
                        searchable: false
                    },
                    {
                        title: 'Verification',
                        name: 'is_approve',
                        data: 'is_approve',
                        searchable: false
                    },
                    {
                        title: 'status',
                        name: 'is_banned',
                        data: 'is_banned',
                        searchable: false
                    },
                    {
                        title: 'action',
                        name: 'action',
                        data: 'action',
                        searchable: false
                    },
                ]
            }, 'exportable');
        });
    </script>
@endpush
