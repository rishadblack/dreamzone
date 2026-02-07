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
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="media">
                    <div class="media-body">
                        <x-input.file wire:model="image_url" label="Select Category Image" size="1024KB" />
                    </div>
                    <div class="mr-25">
                        @if ($image_url)
                            <img class="rounded img-fluid" src="{{ $image_url->temporaryUrl() }}" width="50"
                                height="50" alt="Card image cap">
                        @elseif($image_url_preview)
                            <img class="rounded img-fluid mt-2" src="{{ asset($image_url_preview) }}" width="50"
                                height="50" alt="Card image cap">
                        @endif
                    </div>
                </div>
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
