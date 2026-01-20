<div>
    <x-slot name="header"> Package </x-slot>
    <x-card>
        <div>
            <button type="button" class="btn btn-primary float-end mt-0 mb-2" wire:click="openPackageModal"><span>New
                    Package</span> <em class="icon ni ni-arrow-long-right"></em></button></li>
        </div>
        <div wire:ignore class="table-responsive">
            <livewire:superadmin.datatable.package-table />
        </div>
        <x-modal id="PackageModal" title="{{ $package_id ? 'Update' : 'Create' }} Package" footer="button">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="name" label="Name" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model.defer="type" label="Type" :options="config('status.package_type')" />
                </div>
                {{-- <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="flash_condition" label="Capping" />
                </div> --}}
                <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="point_value" label="PV" />
                </div>
                {{-- <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="amount" label="Amount" />
                </div> --}}
                <div class="col-sm-12 col-lg-12">
                    <x-input.textarea wire:model.defer="details" label="Details" placeholder="Optional.." />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model.defer="status" label="Status" :options="config('status.package_status')" />
                </div>
            </div>
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storePackage"
                    wire:target="storePackage">Save</x-button.default>
            </x-slot>
        </x-modal>
    </x-card>
</div>
@push('js')
    <script>
        // window.loadDataTable = loadDatatable('#table', {
        //     ajax: "{{ route('superadmin.datatable', ['table' => 'packageDatatable']) }}",
        //     columns: [
        //         { title:'ID', data: 'id' },
        //         { title:'Title',name:'name', data: 'name'},
        //         { title:'Type',name:'type', data: 'type'},
        //         { title:'Amount',name:'amount', data: 'amount'},
        //         { title:'Datetime',name:'created_at', data: 'created_at'},
        //         { title:'Status',name:'status', data: 'status'},
        //         { title:'Action',name:'action', data: 'action', exportable: false},
        //     ]
        // }, 'exportable');
    </script>
@endpush
