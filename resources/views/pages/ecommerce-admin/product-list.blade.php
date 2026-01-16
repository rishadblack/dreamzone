<div>
    <x-slot name="title"> Products </x-slot>
    <x-slot name="header"> Product List </x-slot>
    <x-card>
        <div>
            <button type="button" class="btn btn-success float-end mt-0 mb-2 ms-2" wire:click="openProductModal">
                <em class="fa fa-plus me-1"></em><span>Create</span>
            </button>
        </div>
        <livewire:ecommerce-admin.datatable.product-table />
    </x-card>
    <x-modal id="ProductModal" title="{{ $product_id ? 'Update' : 'Create' }} Product" footer="button">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <x-input.text wire:model.defer="name" label="Name" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.text wire:model.defer="code" label="Code" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.text wire:model.defer="short_description" label="Short Description" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.textarea wire:model.defer="description" label="Description" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.select wire:model.defer="type" label="Product Type" :options="config('status.product_type')" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-search.brands wire:model.defer="brand_id" label="Brand" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-search.categories wire:model.defer="category_id" label="Category" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.text wire:model.defer="point" label="Point" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.price wire:model.lazy="price" label="Price" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.text wire:model.lazy="vat" label="Vat" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.text wire:model.lazy="discount" label="Discount" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.price wire:model.defer="net_price" label="Net Price" read-only="true" />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="media">
                    <div class="media-body">
                        <x-input.file-multiple wire:model="product_images" label="Select Product Images"
                            size="1024KB" />
                    </div>
                    <div class="mr-25">
                        @if ($product_images)
                            <p class="pl-1"> Temporary Preview</p>
                            @foreach ($product_images as $productImageItem)
                                <img class="rounded img-fluid" src="{{ $productImageItem->temporaryUrl() }}"
                                    width="50" height="50" alt="Card image cap">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if ($product_image_urls)
            <div class="row mb-3 mt-3">
                @foreach ($product_image_urls as $key => $productImage)
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <img class="rounded img-fluid"
                            src="{{ asset_storage($productImage->image_url) }}?h=200&w=200&fit=stretch"
                            alt="Card image cap">
                        <div class="row">
                            @if ($productImage->is_default)
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="btn btn-success btn-sm">
                                        <small>D</small>
                                    </div>
                                </div>
                            @else
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <button type="button" class="btn btn-warning btn-sm"
                                        wire:click="productImageSetDefault('{{ $productImage->id }}')">
                                        <small>D</small>
                                    </button>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <button type="button" class="btn btn-danger btn-sm"
                                        wire:click="productImageDelete('{{ $productImage->id }}')">
                                        <small>X</small>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <x-input.checkbox wire:model.defer="is_featured" label="Featured" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.select wire:model.defer="status" label="Status" :options="config('status.common_status')" />
            </div>
        </div>
        <x-slot name="footer">
            <x-button.default class="btn btn-success" type="button" wire:click="storeProduct"
                wire:target="storeProduct">Save</x-button.default>
        </x-slot>
    </x-modal>
</div>
