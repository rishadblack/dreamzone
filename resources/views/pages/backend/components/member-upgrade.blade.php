<div>
    <x-modal id="MemberUpgradeModal" title="Account Activation" footer="button">
        @if ($placement_id)
            <div class="row">
                @if (auth()->user()->free_upgrade > 0 || auth()->user()->id == 1)
                    <div class="col-sm-12 col-lg-12">
                        <x-input.checkbox wire:model.live="is_free" label="Special Upgrade" />
                    </div>
                @endif
                <div class="col-sm-12 col-lg-12">
                    <x-input.username wire:model.live="username" label="To Member account" :username_name="$username_name" />
                </div>
                <div class="col-sm-12 col-lg-12" x-show="!$wire.is_sponsor">
                    <x-input.username wire:model.live="sponsor_username" label="Sponsor" :sponsor_username_name="$sponsor_username_name" />
                </div>
                <div class="col-sm-12 col-lg-12 {{ $is_free ? 'd-none' : '' }}">
                    <x-input.price wire:model="value" label="Point Value" :sign="config('app.point_sign')" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <span class="btn btn-sm btn-success">Available Point:
                        {{ pointFormat($available_point, true) }}</span>
                </div>
            </div>
        @endif
        <x-slot name="footer">
            <x-button.default class="btn btn-success" type="button" wire:click="storeActivation"
                wire:target="storeActivation">Submit</x-button.default>
        </x-slot>
    </x-modal>
</div>
