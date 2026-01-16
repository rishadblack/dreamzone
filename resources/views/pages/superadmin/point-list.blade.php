<div>
    <x-slot name="title"> Point List </x-slot>
    <x-slot name="header"> Points </x-slot>
    <x-card>
        <div>
            <button type="button" class="btn btn-primary float-end mt-0 mb-2" wire:click="openPointModal"><span>Generate
                    Point</span> <em class="icon ni ni-arrow-long-right"></em></button></li>
        </div>
        <div wire:ignore class="table-responsive">
            <livewire:superadmin.datatable.point-table />
        </div>
        <x-modal id="PointModal" title="Generate point for member" footer="button">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <x-input.username wire:model.lazy="username" :username_name="$username_name" label="To Member" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model.defer="value" label="Point Value" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model.defer="flow" label="Flow" :options="config('status.point_flow')" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.textarea wire:model.defer="note" label="Remark" placeholder="Optional.." />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model.defer="status" label="Status" :options="config('status.point_status')" />
                </div>
            </div>
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storePoint"
                    wire:target="storePoint">Submit</x-button.default>
            </x-slot>
        </x-modal>
    </x-card>
</div>
