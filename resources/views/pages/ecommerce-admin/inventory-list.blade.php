<div>
    <x-slot name="title"> Inventory </x-slot>
    <x-slot name="header"> Inventory List </x-slot>
    <x-card>

        <x-modal id="InventoryModal" title="Stock Update" footer="button">
            @if ($Product)
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        Product Name: {{ $Product->name }}
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-search.dealer-search wire:model.defer="dealer_id" label="Dealer" />
                    </div>
                    <div class="col-sm-6 col-lg-12">
                        <x-input.text wire:model.defer="quantity" label="Quantity" />
                    </div>
                    <div class="col-sm-6 col-lg-12">
                        <x-input.select wire:model.defer="flow" label="Flow" :options="config('status.order_item_flow')" />
                    </div>
                </div>
            @endif
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storeStock"
                    wire:target="storeStock">Submit</x-button.default>
            </x-slot>
        </x-modal>

        <livewire:ecommerce-admin.datatable.inventory-table />
    </x-card>
</div>
