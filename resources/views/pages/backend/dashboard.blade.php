<div>
    @push('css')
        <style>
            .main-profile-social-list .media-icon,
            .refer-element {
                color: #afafb1 !important;
            }
        </style>
    @endpush
    <x-slot name="header">Dashboard</x-slot>
    <div class="row">
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <x-card class="bg-primary">
                <div class="d-flex mb-1">
                    <div>
                        <h6 class="mb-2">Balance</h6>
                        <h3 class="mb-0 text-dark display-5 fw-bold d-inline-flex">
                            {{ numberFormat($Balance->available_balance, true) }}</h3>
                    </div>
                    <div class="avatar avatar-lg bg-primary-transparent mb-auto ms-auto br-4">
                        <i class="bx bx-bar-chart fs-23"></i>
                    </div>
                </div>
                <small class="mb-0 text-muted">Available Balance</small>
            </x-card>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <x-card class="bg-primary">
                <div class="d-flex mb-1">
                    <div>
                        <h6 class="mb-2">Point</h6>
                        <h3 class="mb-0 text-dark display-5 fw-bold d-inline-flex">
                            {{ pointFormat($Point->available_point, true) }}</h3>
                    </div>
                    <div class="avatar avatar-lg bg-primary-transparent mb-auto ms-auto br-4">
                        <i class="bx bx-bar-chart fs-23"></i>
                    </div>
                </div>
                <small class="mb-0 text-muted">Available Total Point</small>
            </x-card>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <x-card class="bg-primary">
                <div class="d-flex mb-1">
                    <div>
                        <h6 class="mb-2">Wallet Balance</h6>
                        <h3 class="mb-0 text-dark display-5 fw-bold d-inline-flex">
                            {{ numberFormat($TotalIncome - $TotalWithdrawal, true) }}</h3>
                    </div>
                    <div class="avatar avatar-lg bg-primary-transparent mb-auto ms-auto br-4">
                        <i class="bx bx-bar-chart fs-23"></i>
                    </div>
                </div>
                <small class="mb-0 text-muted">Available Wallet Balance</small>
            </x-card>
        </div>
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <x-card class="bg-primary">
                <div class="d-flex mb-1">
                    <div>
                        <h6 class="mb-2">Payout</h6>
                        <h3 class="mb-0 text-dark display-5 fw-bold d-inline-flex">
                            {{ numberFormat($TotalWithdrawal, true) }}</h3>
                    </div>
                    <div class="avatar avatar-lg bg-primary-transparent mb-auto ms-auto br-4">
                        <i class="bx bx-bar-chart fs-23"></i>
                    </div>
                </div>
                <small class="mb-0 text-muted">Total Payout</small>
            </x-card>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <x-card>
                <div class="ps-0">
                    <div class="main-profile-overview">
                        <div class="main-img-user profile-user">
                            <img alt="" src="{{ $User->profile_url }}"><a class="ri-camera-line profile-edit"
                                href="JavaScript:void(0);"></a>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <h5 class="main-profile-name">{{ $User->name }}</h5>
                                <p class="main-profile-name-text">{{ $User->username }}</p>
                            </div>
                        </div>
                        <h6>Details</h6>
                        <div class="main-profile-work-list">
                            <div class="media">
                                <div class="media-logo bg-success-transparent text-success">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </div>
                                <div class="media-body">
                                    <h6>Mobile</h6>
                                    <span>{{ $User->mobile }}</span>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-logo bg-success-transparent text-success">
                                    <i class="fa fa-address-card" aria-hidden="true"></i>
                                </div>
                                <div class="media-body">
                                    <h6>Email</h6>
                                    <span>{{ $User->email }}</span>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-logo bg-success-transparent text-success">
                                    <i class="fa fa-address-book" aria-hidden="true"></i>
                                </div>
                                <div class="media-body">
                                    <h6>Address</h6>
                                    <span>{{ $User->address }}</span>
                                </div>
                            </div>
                        </div>
                        <h6 class="my-3">Account Details</h6>
                        <div class="main-profile-social-list">
                            <div class="media">
                                <div class="media-icon bg-primary-transparent text-primary">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                                <div class="media-body">
                                    <span>Refer By</span>
                                    {{-- <a class="refer-element" href="javascript:void(0);">{{ $User->memberTree->sponsor_id ? $User->memberTree->bySponsor->username : 'System' }}</a> --}}
                                </div>
                            </div>
                            {{-- <div class="media">
                                <div class="media-icon bg-success-transparent text-success">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                                <div class="media-body">
                                    <span>Placement By</span> <a
                                        href="javascript:void(0);">{{ $User->memberTree->placement_id ? $User->memberTree->byPlacement->username : 'System' }}</a>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-info-transparent text-info">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                </div>
                                <div class="media-body">
                                    <span>Activation Date</span> <a
                                        href="javascript:void(0);">{{ $User->memberTree->is_premium ? $User->memberTree->is_premium->format('d-M-Y') : 'Not Active' }}</a>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-icon bg-danger-transparent text-danger">
                                    <i class="ri-link-unlink-m"></i>
                                </div>
                                <div class="media-body">
                                    <span>Achievement</span> <a
                                        href="javascript:void(0);">{{ $User->memberTree->incentive_id ? config('mlm.incentives.' . $User->memberTree->incentive_id . '.title') : 'Not Active' }}</a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="row mt-2 pb-2 bg-primary">
                        <div class="col-lg-12">
                            <x-input.text-copy wire:model="ref_url" label="Share referral link" read-only="true" />
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="col-lg-8">
            <div class="row">
                {{-- <div class="col-xl-3 col-lg-6 col-md-6">
                    <x-card class="bg-primary-transparent">
                        <div class="counter-status md-mb-0">
                            <div class="text-center mb-2">
                                <x-heroicon-m-link class="about-icons" />
                            </div>
                            <div class="text-center text-white">
                                <h2 class="counter mb-2">{{ $TotalSponsor }}</h2>
                                <h6 class="mb-0">Total Refer</h6>
                            </div>
                        </div>
                    </x-card>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="card bg-danger-transparent">
                        <div class="card-body">
                            <div class="counter-status md-mb-0">
                                <div class="text-center mb-1"> <x-heroicon-c-currency-dollar class="about-icons" />
                                </div>
                                <div class="text-center mb-1">
                                    <h2 class="counter mb-2">{{ numberFormat($User->roi_income, true) }}</h2>
                                    <h6 class="mb-0">Honorarium</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="card bg-warning-transparent">
                        <div class="card-body">
                            <div class="counter-status md-mb-0">
                                <div class="text-center mb-1"> <x-heroicon-c-currency-dollar class="about-icons" />
                                </div>
                                <div class="text-center mb-1">
                                    <h2 class="counter mb-2">{{ numberFormat($User->generation_income, true) }}</h2>
                                    <h6 class="mb-0">Team Commission</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="card bg-info-transparent">
                        <div class="card-body">
                            <div class="counter-status md-mb-0">
                                <div class="text-center mb-1"> <x-heroicon-c-currency-dollar class="about-icons" />
                                </div>
                                <div class="text-center mb-1">
                                    <h2 class="counter mb-2">{{ numberFormat($User->incentive_income, true) }}</h2>
                                    <h6 class="mb-0">Incentives</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6">
                    <div class="card bg-info-transparent">
                        <div class="card-body">
                            <div class="counter-status md-mb-0">
                                <div class="text-center mb-1"> <x-heroicon-c-currency-dollar class="about-icons" />
                                </div>
                                <div class="text-center mb-1">
                                    <h2 class="counter mb-2">{{ numberFormat($TotalAttach, true) }}</h2>
                                    <h6 class="mb-0">Total Commission</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <x-modal id="NoticModal" title="Notic / Announcement">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h6 class="text-center">
                    {{ setting('notic_msg') }}
                </h6>
            </div>
    </x-modal>
</div>

@push('js')
    <script></script>
@endpush
