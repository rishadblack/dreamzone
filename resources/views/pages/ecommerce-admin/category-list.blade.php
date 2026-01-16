<div>
    <x-slot name="title"> Categories </x-slot>
    <x-slot name="header"> Category List </x-slot>
    <x-card>
        <div>
            <button type="button" class="btn btn-success float-end mt-0 mb-2 ms-2" wire:click="openCategoryModal">
                <em class="fa fa-plus me-1"></em><span>Create</span>
            </button>
        </div>

        <livewire:ecommerce-admin.datatable.category-table />
    </x-card>

    <x-modal id="CategoryModal" title="{{ $category_id ? 'Update' : 'Create' }} Category" footer="button">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <x-input.text wire:model="name" label="Name" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.select wire:model="status" label="Status" :options="config('status.common_status')" />
            </div>
        </div>
        <x-slot name="footer">
            <x-button.default class="btn btn-success" type="button" wire:click="storeCategory"
                wire:target="storeCategory">Save</x-button.default>
        </x-slot>
    </x-modal>
</div>
