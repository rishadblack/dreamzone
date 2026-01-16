<div>
    <x-slot name="header"> Balance Report </x-slot>
    <x-card>
        <div class="row">
            <div class="col-sm-12 col-lg-4">
                <x-input.select wire:model.defer="filter_status" label="Balance Status" class="updateDatatable"
                    :options="config('status.balance_status')" />
            </div>
            <div class="col-sm-12 col-lg-4">
                <x-input.select wire:model.defer="filter_flow" label="Balance Flow" class="updateDatatable"
                    :options="config('status.point_flow')" />
            </div>
            <div class="col-sm-12 col-lg-4">
                <x-input.select wire:model.defer="filter_type" label="Balance Type" class="updateDatatable"
                    :options="config('status.balance_type')" />
            </div>
            <div class="col-sm-12 col-lg-4">
                <x-input.date-range wire:model.defer="date_filter" loadJs="true" class="updateDatatable"
                    label="Date Filter" />
            </div>
        </div>

        <livewire:superadmin.datatable.balance-report-table />
    </x-card>
</div>
@push('js')
    {{-- <script>
    window.loadDataTable = loadDatatable('#table', {
            ajax:{
				url:"{{route('superadmin.datatable',['table' => 'balanceListDatatable'])}}",
				data:function(data){
					data.flow = $('select[name="filter_flow"]').val();
					data.status = $('select[name="filter_status"]').val();
					data.type = $('select[name="filter_type"]').val();
                    data.start_date = window.drp_date_filter.startDate.format('YYYY-MM-DD');
					data.end_date = window.drp_date_filter.endDate.format('YYYY-MM-DD');
				}
			},
			columns: [
                { title:'ID', data: 'id' },
                { title:'Name', name: 'User.name', data: 'user.name' },
                { title:'Username', name: 'User.username', data: 'user.username'},
                { title:'Type', name: 'type', data: 'type'},
                { title:'Flow', name: 'flow', data: 'flow'},
                { title:'User Id',name: 'User.username', data: 'user.username'},
                { title:'Amount',name:'amount', data: 'amount'},
                { title:'Note',name:'note', data: 'note'},
                { title:'Datetime',name:'created_at', data: 'created_at'},
                { title:'status',name:'status', data: 'status'},
			]
    }, 'exportable');
</script> --}}
@endpush
