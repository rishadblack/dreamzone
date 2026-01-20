<div>
    <x-slot name="title">Withdrawal</x-slot>
    <x-slot name="header">Withdrawal</x-slot>
    <div class="row">
        <div class="col-lg-12 col-xl-3">
            <x-card>
                <x-slot name="card_title">New Withdrawal</x-slot>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <label for="account_balance">Wallet: </label>
                        {{ numberFormat($available_income, true) }}
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.select wire:model.live="type" label="Withdraw Type" :options="config('status.withdrawal_type')" />
                    </div>
                    @if ($type == 2)
                        <div class="col-sm-12 col-lg-12">
                            <x-input.select wire:model.change="payment_method_id" label="Payment Method"
                                :options="config('status.payment_method')" />
                        </div>
                        {{-- @if ($payment_method_id && config('status.payment_method.' . $payment_method_id . '.logo'))
                            <div class="col-sm-12 col-lg-12">
                                <img src="{{ asset('backend/payment-method/' . config('status.payment_method.' . $payment_method_id . '.logo')) }}"
                                    class="mt-2 mb-2 img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                                    alt="">
                            </div>
                        @endif --}}
                        @if ($payment_method_id != 1)
                            <div class="col-sm-12 col-lg-12">
                                <x-input.text wire:model="account_no" label="Account Number" />
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <x-input.text wire:model="account_details" label="Account Additional Details" />
                            </div>
                        @endif
                    @endif
                    <div class="col-sm-12 col-lg-12 {{ $type == 3 ? '' : 'd-none' }}">
                        <x-input.username wire:model.live="username" label="To Member" :username_name="$username_name" />
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.price wire:model.live.debounce.1000ms="amount" label="Amount" />
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.price wire:model="charge" label="Charge" read-only="true" />
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.price wire:model="net_amount" label="Net Amount" read-only="true" />
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.textarea wire:model="note" label="Remark" placeholder="Optional.." />
                    </div>
                    <div class="col-md-4">
                        <x-button.default wire:click="storeWithdrawal" wire:target="storeWithdrawal"
                            class="btn-warning mt-2">Submit</x-button.default>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-lg-12 col-xl-9">
            <x-card>
                <livewire:backend.datatable.withdrawal-table />
            </x-card>
        </div>
    </div>
</div>
