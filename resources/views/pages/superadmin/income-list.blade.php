<div>
    <x-slot name="header"> Income Report </x-slot>
    <x-card>
        <livewire:superadmin.datatable.income-table />
        <x-modal id="IncomeModal" title="Update Income" footer="button">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <x-input.username wire:model.blur="username" label="To Member" :username_name="$username_name" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model="type" label="Income Type" :options="config('status.income_type')" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model="amount" label="Amount" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.textarea wire:model="note" label="Remark" placeholder="Optional.." />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model="status" label="Status" :options="config('status.balance_status')" />
                </div>
            </div>
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storeIncome"
                    wire:target="storeIncome">Submit</x-button.default>
            </x-slot>
        </x-modal>
    </x-card>
</div>
