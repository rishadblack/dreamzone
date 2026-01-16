<div>
    <x-slot name="header"> Statement </x-slot>
    <x-card>
        <div>
            Server Time : {{ now()->format('d-m-Y h:i:s a') }}
            <button type="button" class="btn btn-primary float-end mt-0 mb-2" wire:click="openStatementModal"><span>New
                    Statement</span> <em class="icon ni ni-arrow-long-right"></em></button></li>
        </div>
        <div wire:ignore class="table-responsive">
            <livewire:superadmin.datatable.statement-table />
        </div>
        <x-modal id="StatementModal" title="Statement" footer="button">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model.defer="type" label="Type" :options="config('status.statement_type')" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="percentage" label="Percentage To Distribute" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.date wire:model.defer="close_date" label="Close Date" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model.defer="status" label="Status" :options="config('status.statement_status')" />
                </div>
            </div>
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storeStatement"
                    wire:target="storeStatement">Save</x-button.default>
            </x-slot>
        </x-modal>
    </x-card>
</div>
