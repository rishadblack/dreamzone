<div>
    <x-slot name="header"> Withdrawal Report  </x-slot>
    <x-card>
        <div class="row">
            <div class="col-sm-12 col-lg-4">
                <x-input.select wire:model="filter_status" label="Withdrawal Status" class="updateDatatable" :options="config('status.withdrawal_status')" />
            </div>
            <div class="col-sm-12 col-lg-4">
                <x-input.date-range wire:model="date_filter" loadJs="true" class="updateDatatable" label="Date Filter" />
            </div>
        </div>
        <div wire:ignore class="table-responsive">
            <livewire:superadmin.datatable.withdrawal-report-table />
        </div>
    </x-card>
</div>
@push('js')
{{-- <script>
    window.loadDataTable = loadDatatable('#table', {
            ajax:{
				url:"{{route('superadmin.datatable',['table' => 'withdrawalListDatatable'])}}",
				data:function(data){
					data.status = $('select[name="filter_status"]').val();
                    data.start_date = window.drp_date_filter.startDate.format('YYYY-MM-DD');
					data.end_date = window.drp_date_filter.endDate.format('YYYY-MM-DD');
				}
			},
			columns: [
                { title:'ID', data: 'id' },
                { title:'Name', name: 'User.name', data: 'user.name' },
                { title:'Username', name: 'User.username', data: 'user.username'},
                { title:'Type', name: 'type', data: 'type'},
                { title:'Payment Method', name: 'payment_method_id', data: 'payment_method_id'},
                { title:'Account No', name: 'account_no', data: 'account_no'},
                { title:'Account Details', name: 'account_details', data: 'account_details'},
                { title:'Amount',name:'amount', data: 'amount'},
                { title:'Charge',name:'charge', data: 'charge'},
                { title:'Net Amount',name:'net_amount', data: 'net_amount'},
                { title:'Note',name:'note', data: 'note'},
                { title:'Datetime',name:'created_at', data: 'created_at'},
                { title:'status',name:'status', data: 'status'},
			]
    }, 'exportable');
</script> --}}
@endpush
