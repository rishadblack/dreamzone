<div>
    <x-slot name="title"> Investment List </x-slot>
    <x-slot name="header"> Investment List </x-slot>
    <x-card>
        <livewire:superadmin.datatable.fund-table />
    </x-card>

    <x-modal id="DetachedModal" title="Fund Detached" size="lg">
        <p>
            Name : {{ $name }}<br />
            Username : {{ $username }}<br />
            Atached Request Amount : {{ $net_amount }}<br />
            Atached Request Date : {{ $is_attached_request }}<br />
            Atached Date : {{ $is_attached }}<br />
            Atached Amount : {{ $attached_amount }}<br />
        </p>
        <hr>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <x-input.price wire:model.defer="detached_amount" label="Detached Amount"
                    placeholder="Detached Amount.." />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.select wire:model.defer="status" label="Status" :options="config('status.fund_status')" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.textarea wire:model.defer="note" label="Remark" placeholder="Optional.." />
            </div>
        </div>
        <x-slot name="footer">
            <x-button.default class="btn btn-success" type="button" wire:click="storeDetached"
                wire:target='storeDetached'>Submit</x-button.default>
        </x-slot>
    </x-modal>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            window.loadDataTable = loadDatatable('#reportTable', {
                ajax: {
                    url: "{{ route('superadmin.datatable', ['table' => 'fundAttachedDatatable']) }}",
                    data: function(data) {
                        data.status = $('select[name="filter_status"]').val();
                        data.start_date = $('input#date_filter').data('daterangepicker').startDate
                            .format('YYYY-MM-DD');
                        data.end_date = $('input#date_filter').data('daterangepicker').endDate.format(
                            'YYYY-MM-DD');
                    }
                },
                columns: [{
                        title: 'ID',
                        name: 'id',
                        data: 'id'
                    },
                    {
                        title: 'Name',
                        name: 'User.name',
                        data: 'user.name'
                    },
                    {
                        title: 'Username',
                        name: 'User.username',
                        data: 'user.username'
                    },
                    {
                        title: 'Attached Request',
                        name: 'is_attached_request',
                        data: 'is_attached_request'
                    },
                    {
                        title: 'Attached Date',
                        name: 'is_attached',
                        data: 'is_attached'
                    },
                    {
                        title: 'Attached Amount',
                        name: 'amount',
                        data: 'amount'
                    },
                    {
                        title: 'Detached Request',
                        name: 'is_detached_request',
                        data: 'is_detached_request'
                    },
                    {
                        title: 'Detached Date',
                        name: 'is_detached',
                        data: 'is_detached'
                    },
                    {
                        title: 'Detached Amount',
                        name: 'detached_amount',
                        data: 'detached_amount'
                    },
                    {
                        title: 'Status',
                        name: 'status',
                        data: 'status'
                    },
                    {
                        title: 'Action',
                        name: 'action',
                        data: 'action'
                    },
                ]
            });
        });
    </script>
@endpush
