<div>
    <x-slot name="title"> Brands </x-slot>
    <x-slot name="header"> Brand List </x-slot>
    <x-card>
        <div>
            <button type="button" class="btn btn-success float-end mt-0 mb-2 ms-2" wire:click="openBrandModal">
                <em class="fa fa-plus me-1"></em><span>Create</span>
            </button>
        </div>

        <livewire:ecommerce-admin.datatable.brand-table />
    </x-card>

    <x-modal id="BrandModal" title="{{ $brand_id ? 'Update' : 'Create' }} Brand" footer="button">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <x-input.text wire:model="name" label="Name" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.select wire:model="status" label="Status" :options="config('status.common_status')" />
            </div>
        </div>
        <x-slot name="footer">
            <x-button.default class="btn btn-success" type="button" wire:click="storeBrand"
                wire:target="storeBrand">Save</x-button.default>
        </x-slot>
    </x-modal>
</div>
