<div>
    <x-slot name="title">Profile Update</x-slot>
    <x-slot name="header">Profile Update</x-slot>
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <x-card>
                <x-slot name="card_title">Personal Details</x-slot>
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <x-input.text wire:model="name" label="Name" :read-only="true" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="mt-3 media">
                            <div class="media-body">
                                <x-input.file wire:model="profile_image" label="Profile Photo" size="1024 KB" />
                            </div>
                            <div class="mr-25">
                                @if ($profile_image)
                                    <img src="{{ $profile_image->temporaryUrl() }}" width="80" height="80"
                                        alt="" class="rounded mr-50">
                                @elseif($profile_image_preview)
                                    <img src="{{ asset_storage($profile_image_preview) }}?h=80&w=80&fit=stretch"
                                        width="80" height="80" alt="" class="rounded mr-50">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.text wire:model="email" label="Email" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.text wire:model="mobile" label="Phone" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.text wire:model="address" label="Street" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.text wire:model="city" label="City" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.text wire:model="post_code" label="Postal code" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.text wire:model="state" label="State" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.select wire:model="country_id" label="Country">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </x-input.select>
                    </div>
                </div>
                <div class="mt-3 mb-2">
                    <x-button.default class="btn btn-primary" wire:click="storeProfileUpdate"
                        wire:target="storeProfileUpdate">
                        Update</x-button.default>
                </div>
            </x-card>
        </div>
        <div class="col-lg-12 col-xl-12">
            <x-card>
                <x-slot name="card_title">Password Change</x-slot>
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <x-input.password wire:model.lazy="current_password" label="Current Password" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.password wire:model.lazy="password" label="New Password" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.password wire:model.lazy="password_confirmation" label="Confirm New Password" />
                    </div>
                </div>
                <div class="mt-3">
                    <x-button.default class="btn btn-primary" wire:click="storePasswordChange"
                        wire:target="storePasswordChange">
                        Update</x-button.default>
                </div>
            </x-card>
        </div>
    </div>
</div>
