<div>
    <x-slot name="title">Manage Wallet</x-slot>
    <x-slot name="header">Manage Wallet</x-slot>
    <div class="row">
        <div class="col-lg-12 col-xl-3">
            <x-card>
                <x-slot name="card_title">Manage Wallet</x-slot>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <label for="account_balance">Wallet Balance: </label>
                        {{ numberFormat($available_balance, true) }}
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.username wire:model.live="username" label="To Member account" :username_name="$username_name" />
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.price wire:model="amount" label="Amount" />
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.textarea wire:model="note" label="My Remark" placeholder="Optional.." />
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.textarea wire:model="to_note" label="Member's remark" placeholder="Optional.." />
                    </div>
                    <div class="col-md-4">
                        <x-button.default wire:click="storeBalanceTransfer" wire:target="storeBalanceTransfer"
                            class="btn-warning mt-2">Submit</x-button.default>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-lg-12 col-xl-9">
            <x-card>
                {{-- <x-slot name="card_title">Wallet Statement</x-slot>
                <div wire:ignore class="table-responsive">
                    <table id="table" class="table table-sm table-bordered text-nowrap border-bottom"></table>
                </div> --}}
                <livewire:backend.datatable.balance-table />
            </x-card>
        </div>
    </div>
</div>
