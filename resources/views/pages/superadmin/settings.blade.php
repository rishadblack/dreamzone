<div>
    <x-slot name="header"> Settings </x-slot>
    <x-card>
        <x-slot name="card_title">
            <h6 class="text-white">Settings</h6>
        </x-slot>
        <div class="row">
            <div class="col-lg-3">
                SMS Balance : {{ numberFormat($User->sms_balance, true) }}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <x-input.select wire:model="parameter.access_user_login" label="Access User Login">
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                </x-input.select>
            </div>
            <div class="col-lg-3">
                <x-input.select wire:model="parameter.access_user_register" label="Access Registration">
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                </x-input.select>
            </div>
            <div class="col-lg-3">
                <x-input.select wire:model="parameter.access_withdrawal" label="Withdrawal Enable">
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                </x-input.select>
            </div>
            <div class="col-lg-3">
                <x-input.select wire:model="parameter.access_transfer" label="Transfer Enable">
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                </x-input.select>
            </div>
            <div class="col-lg-3">
                <x-input.select wire:model="parameter.show_notic" label="Notic Enable">
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                </x-input.select>
            </div>
            <div
                class="col-lg-12 {{ isset($parameter['show_notic']) && $parameter['show_notic'] == 'Y' ? '' : 'd-none' }}">
                <x-input.textarea wire:model="parameter.notic_msg" label="Notic Message" />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <x-button.default class="btn btn-success" type="button" wire:click="parameterStore"
                    wire:target="parameterStore">Save</x-button.default>
            </div>
        </div>
    </x-card>
</div>
