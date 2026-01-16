<div>
    <x-slot name="header"> Fund Generate </x-slot>
    <x-card>
        <div>
            <button type="button" class="btn btn-success float-end mt-0 mb-2"
                wire:click="openBalanceGenerateModal"><span>Generate Balance</span> <em
                    class="icon ni ni-arrow-long-right"></em></button></li>
        </div>
        <livewire:superadmin.datatable.generate-balance-table />
        <x-modal id="BalanceGenerateModal" title="Generate balance and transfer to member" footer="button">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <x-input.username wire:model.blur="username" label="To Member" :username_name="$username_name" />
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
                <x-button.default class="btn btn-success" type="button" wire:click="storeBalanceGenerate"
                    wire:target="storeBalanceGenerate">Submit</x-button.default>
            </x-slot>
        </x-modal>
    </x-card>
</div>
