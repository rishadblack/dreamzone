<div>
    <x-slot name="header"> Fund Generate  </x-slot>
    <x-card>
        <div class="row">
            <div class="col-sm-12 col-lg-4">
                <x-input.select wire:model="filter_incentives" label="All Rank" class="updateDatatable" :options="config('mlm.incentives')" />
            </div>
            <div class="col-sm-12 col-lg-4">
                <x-input.select wire:model="filter_type" label="Incentive Received" class="updateDatatable">
                    <option value="1">Received</option>
                    <option value="2">Not Received</option>
                </x-input.select>
            </div>
            <div class="col-sm-12 col-lg-4">
                <x-input.date-range wire:model="date_filter" loadJs="true" label="Date Filter" class="updateDatatable" />
            </div>
        </div>
        <div wire:ignore class="table-responsive">
            <livewire:superadmin.datatable.achievement-table />
        </div>
    </x-card>
</div>
@push('js')
{{-- <script>
    window.loadDataTable = loadDatatable('#table', {
            ajax:{
				url:"{{route('superadmin.datatable',['table' => 'achievementDatatable'])}}",
				data:function(data){
					data.incentive_id = $('select[name="filter_incentives"]').val();
					data.type = $('select[name="filter_type"]').val();
                    data.start_date = window.drp_date_filter.startDate.format('YYYY-MM-DD');
					data.end_date = window.drp_date_filter.endDate.format('YYYY-MM-DD');
				}
			},
			columns: [
                { title:'ID', data: 'id' },
                { title:'Name', name: 'User.name', data: 'user.name' },
                { title:'Username', name: 'User.username', data: 'user.username'},
                { title:'Rank Name',name: 'incentive_id', data: 'incentive_id'},
                { title:'Incentive Receive',name: 'is_received', data: 'is_received'},
                { title:'Achieve Date',name:'created_at', data: 'created_at'},
                { title:'Status',name:'status', data: 'status'},
                { title:'Action',name:'action', data: 'action'},
			]
    }, 'exportable');
</script> --}}
@endpush
