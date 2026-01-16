<div>
    <x-slot name="header"> Deposit Receive </x-slot>
    <x-card>
        <div class="row">
            <div class="col-sm-12 col-lg-4">
                <x-input.select wire:model="filter_status" label="Deposit Status" :options="config('status.deposit_status')" />
            </div>
            <div class="col-sm-12 col-lg-4">
                <x-input.date-range wire:model="date_filter" loadJs="true" label="Date Filter" />
            </div>
        </div>
        <livewire:superadmin.datatable.deposit-table />
        <x-modal id="DepositModal" title="Account Deposit" footer="button">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model.live="payment_method_id" label="Deposit Payment Method"
                        :options="config('status.payment_method')" />
                </div>
                @if ($payment_method_id)
                    <div class="col-sm-12 col-lg-12">
                        <img src="{{ asset('backend/payment-method/' . config('status.payment_method.' . $payment_method_id . '.logo')) }}"
                            class="mt-2 mb-2 img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                            alt="">
                    </div>
                @endif
                <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model="account_details" label="Transaction Details" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model.live.debounce.1000ms="amount" label="Amount" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model.live.debounce.1000ms="charge" label="Charge" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model="net_amount" label="Net Amount" read-only="true" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model="status" label="Status" :options="config('status.deposit_status')" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.textarea wire:model="note" label="Remark" placeholder="Optional.." />
                </div>
            </div>
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storeDeposit"
                    wire:target="storeDeposit">Submit</x-button.default>
            </x-slot>
        </x-modal>
    </x-card>
</div>
