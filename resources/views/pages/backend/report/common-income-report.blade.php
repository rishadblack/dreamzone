<div>
    <x-slot name="header">{{ $incomeType->title }} Report</x-slot>
    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <x-card>
                {{-- @if ($incomeType->income_type == 1)
                    <livewire:backend.datatable.report.sponsor-income-report-table />
                @else --}}
                <livewire:backend.datatable.report.common-income-report-table :income_type="$incomeType->income_type" />
                {{-- @endif --}}
            </x-card>
        </div>
    </div>
</div>
