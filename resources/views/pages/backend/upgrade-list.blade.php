<div>
    <x-slot name="title">Upgrade</x-slot>
    <x-slot name="header">Upgrade</x-slot>
    <div class="row">
        <div class="col-lg-12 col-xl-3">
            <x-card>
                <x-slot name="card_title">Upgrade</x-slot>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <label for="account_balance">Point: </label>
                        {{ pointFormat($available_point, true) }}
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.checkbox wire:model.live="is_self_upgrade" label="Self Upgrade" />
                    </div>
                    <div class="col-sm-12 col-lg-12 {{ $is_self_upgrade ? 'd-none' : '' }}">
                        <x-input.username wire:model.live="username" label="To Member account" :username_name="$username_name" />
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.price wire:model="value" label="Point Value" :sign="config('app.point_sign')" />
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <x-input.checkbox wire:model="is_agree"
                            label="I have accepted all the terms and conditions of your site." />
                    </div>
                    <div class="col-md-4">
                        <x-button.default wire:click="storeActivation" wire:target="storeActivation"
                            class="btn-warning mt-2">Submit</x-button.default>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-lg-12 col-xl-9">
            <x-card>
                <x-slot name="card_title">Upgrade History</x-slot>
                <livewire:backend.datatable.upgrade-table />
            </x-card>
        </div>
    </div>
</div>
