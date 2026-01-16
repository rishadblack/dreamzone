<div>
    <x-slot name="title">Wallet Deposit</x-slot>
    <x-slot name="header">Wallet Deposit</x-slot>
    <div class="row">
        <div class="col-lg-12 col-xl-3">
            <x-card>
                <x-slot name="card_title">Wallet Deposit</x-slot>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <x-input.select wire:model.live="payment_method_id" label="Deposit Payment Method"
                            :options="config('status.payment_method')" />

                    </div>
                    @if ($payment_method_id)
                        <div class="col-sm-12 col-lg-12">
                            <img src="{{ asset('images/' . config('status.payment_method.' . $payment_method_id . '.logo')) }}"
                                class="mt-2 mb-2 img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                                alt="">
                        </div>
                    @endif
                    <div class="col-sm-12 col-lg-12">
                        <x-input.price wire:model.live.debounce.1000ms="amount" label="Amount" />
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.text wire:model="account_details" label="Transaction Details" />
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.price wire:model="net_amount" label="Net Amount" read-only="true" />
                    </div>
                    @if ($payment_method_id)
                        <div class="col-sm-12 col-lg-12">
                            <x-input.text-copy wire:model="to_account" label="Deposit TRC20 Account" read-only="true" />
                        </div>
                        <div class="col-sm-12 col-lg-12 text-center">
                            <img class="mt-2 mb-2 img-fluid"
                                src="data:images/png;base64, {{ base64_encode(QrCode::format('png')->size(200)->merge(asset_logo(), 0.5, true)->generate(config('status.payment_method.' . $payment_method_id . '.account_no'))) }}"
                                alt="">
                        </div>
                    @endif
                    <div class="col-sm-12 col-lg-12">
                        <x-input.textarea wire:model="note" label="Remark" placeholder="Optional.." />
                    </div>
                    <div class="col-md-4">
                        <x-button.default wire:click="storeDeposit" wire:target="storeDeposit"
                            class="btn-warning mt-2">Submit</x-button.default>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-lg-12 col-xl-9">
            <x-card>
                <livewire:backend.datatable.deposit-table />
            </x-card>
        </div>
    </div>
</div>
