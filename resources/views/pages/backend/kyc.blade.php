<div>
    <x-slot name="title">KYC Update</x-slot>
    <x-slot name="header">KYC Update</x-slot>
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <x-card>
                <x-slot name="card_title">Personal Particulars</x-slot>
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <x-input.text wire:model="name" label="Name" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="media mt-3">
                            <div class="media-body">
                                <x-input.file wire:model="profile_image" label="Profile Photo" size="1024 KB" />
                            </div>
                            <div class="mr-25">
                                @if ($profile_image)
                                    <img src="{{ $profile_image->temporaryUrl() }}" width="80" height="80"
                                        alt="" class="rounded mr-50">
                                @elseif($profile_image_preview)
                                    <img src="{{ $profile_image_preview }}?h=80&w=80&fit=stretch" width="80"
                                        height="80" alt="" class="rounded mr-50">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.text wire:model="national_id" label="National Id/Passport" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <div class="media mt-3">
                            <div class="media-body">
                                <x-input.file wire:model="national_id_image" label="National Id Photo /Passport Photo"
                                    size="1024 KB" />
                            </div>
                            <div class="mr-25">
                                @if ($national_id_image)
                                    <img src="{{ $national_id_image->temporaryUrl() }}" width="80" height="80"
                                        alt="" class="rounded mr-50">
                                @elseif($national_id_image_preview)
                                    <img src="{{ $national_id_image_preview }}?h=80&w=80&fit=stretch" width="80"
                                        height="80" alt="" class="rounded mr-50">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.date wire:model="birth" label="Date Of Birth" />
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-lg-12 col-xl-12">
            <x-card>
                <x-slot name="card_title">Contact method</x-slot>
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <x-input.text wire:model="email" label="Email" />
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <x-input.text wire:model="mobile" label="Phone" />
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-lg-12 col-xl-12">
            <x-card>
                <x-slot name="card_title">Residential address</x-slot>
                <div class="row">
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
                    <div class="col-sm-12 col-lg-12">
                        <x-input.checkbox wire:model.lazy="all_checked"
                            label="I have read, understand and accept the terms and conditions described in the all the legal documents above." />
                    </div>
                </div>
                @if (!Auth::User()->is_agree)
                    <div class="mt-3">
                        <x-button.default class="btn btn-success" wire:click="storeVerify"
                            wire:target="storeVerify">Update</x-button.default>
                    </div>
                @endif
            </x-card>
        </div>
    </div>
</div>
