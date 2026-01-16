<div>
    <x-slot name="title">Attached</x-slot>
    <x-slot name="header">Attached</x-slot>
    {{-- <x-card> --}}
    <x-slot name="card_title">Attachment History</x-slot>
    <div class="row">
        @foreach ($packages as $package)
            <div class="col-sm-6 col-lg-6 col-md-6 col-xl-3">
                <x-card>
                    <div class="bg-warning text-center br-4 py-4">

                        <h3 class="fw-semibold mb-1">{{ getIndexValue($package->name) }}</h3> <span
                            class="fs-15">{{ getIndexValue($package->name, 1) }}</span>
                    </div>
                    <ul class="list-unstyled pricing-cards-row3">
                        @foreach (convertPipeToArray($package->details) as $details)
                            <li class="d-flex justify-content align-items-center border-bottom-0 mb-4"> <i
                                    class="ri-check-line fw-bolder bg-warning-transparent p-1 rounded-circle lh-1"></i>
                                <span class="fs-13 ms-2"><b>{{ getIndexValue($details) }}</b>
                                    {{ getIndexValue($details, 1) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    @if (auth()->user()->memberTree->package_id == $package->id)
                        <div class="sign-up-here"> <button type="button" class="btn-success btn">Current</button>
                        </div>
                    @else
                        <div class="sign-up-here"> <button type="button" class="btn-info btn">Available</button> </div>
                    @endif
                </x-card>
            </div><!-- COL-END -->
        @endforeach
    </div>
    {{-- </x-card> --}}
</div>
