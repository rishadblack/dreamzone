<div>
    <x-slot name="header"> Withdrawal Pay </x-slot>
    <x-card>
        <div class="row">
            <div class="col-sm-12 col-lg-4">
                <x-input.select wire:model="filter_status" label="Withdrawal Status" class="updateDatatable"
                    :options="config('status.withdrawal_status')" />
            </div>
            <div class="col-sm-12 col-lg-4">
                <x-input.date-range wire:model="date_filter" loadJs="true" class="updateDatatable" label="Date Filter" />
            </div>
        </div>
        <div wire:ignore class="table-responsive">
            <livewire:superadmin.datatable.withdrawal-pay-table />
        </div>
        <x-modal id="WithdrawalPayModal" title="Account Withdrawal" footer="button">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <label for="name">Name : {{ $name }}</label>,<br />
                    <label for="name">UserId : {{ $username }}</label>,<br />
                    <label for="phone">Phone : {{ $phone }}</label>,<br />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model.live="payment_method_id" label="Payment Method" :options="config('status.payment_method')" />
                </div>
                <div class="col-sm-12 col-lg-12 {{ $payment_method_id == 1 ? 'd-none' : '' }}">
                    <x-input.text wire:model="account_no" label="Account No/Hash No" />
                </div>
                <div class="col-sm-12 col-lg-12 {{ $payment_method_id == 1 ? 'd-none' : '' }}">
                    <x-input.text wire:model="account_details" label="Account Details" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model.debounce.1000ms="amount" label="Amount" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model.debounce.1000ms="charge" label="Charge" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model="net_amount" label="Net Amount" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.textarea wire:model="note" label="Remark" placeholder="Optional.." />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model="status" label="Status" :options="config('status.withdrawal_status')" />
                </div>
            </div>
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storeWithdrawal"
                    wire:target="storeWithdrawal">Submit</x-button.default>
            </x-slot>
        </x-modal>
    </x-card>
</div>
