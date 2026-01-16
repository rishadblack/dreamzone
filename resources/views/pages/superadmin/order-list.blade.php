<div>
    <x-slot name="title">
        Order List
    </x-slot>
    <div class="container-fluid dashboard-default-sec">
        <div class="row starter-main">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="pb-0 card-header">
                        <h5 class="float-left card-title">All Order List</h5>
                        <div class="pt-0 bookmark">
                            <button class="mt-1 btn btn-primary" type="button" wire:click="openOrderModal">New Order</button>
                          </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">

                            </div>
                        </div>
                        <div wire:ignore class="mb-4 table-responsive">
                            <table id="reportTable" class="table table-sm"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-modal id="OrderModal" title="Generate balance and transfer to user" footer="button">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="ticket_id" label="Ticket Id"/>
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="order_type" label="Order Type"/>
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model.defer="base_capital" label="Base Capital" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="currency" label="Currency"/>
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="volume" label="Volume"/>
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="comment" label="Comment"/>
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model.defer="close_price" label="Close Price" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.date wire:model.defer="close_time" label="Close Price" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model.defer="commission" label="Commission" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model.defer="swap" label="Swap" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="share_percentage" label="Share Percentage" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.date wire:model.defer="share_date" label="Closing Date" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.select wire:model.defer="status" label="Status" :options="config('status.order_status')"/>
                </div>
            </div>
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storeOrder" wire:target="storeOrder">Submit</x-button.default>
            </x-slot>
        </x-modal>
    </div>
</div>

@push('js')
<script >
        function callView(id) {
            @this.call('openOrderModal', id);
        }

	$(document).ready(function(){
		var dataTable = $('#reportTable').DataTable({
			processing: true,
			serverSide: true,
            order: [[ 0, "desc" ]],
			ajax: "{{route('superadmin.datatable',['table' => 'orderDatatable'])}}",
			columns: [
                { title:'ID', data: 'id' },
                { title:'Add By', name: 'User.name', data: 'user.name'},
                { name:'ticket_id',title:'Ticker Id', data: 'ticket_id'},
                { name:'order_type',title:'Type', data: 'order_type'},
                { name:'base_capital',title:'Base Capital', data: 'base_capital'},
                { name:'currency',title:'Currency', data: 'currency'},
                { name:'volume',title:'Volume', data: 'volume'},
                { name:'comment',title:'Comment', data: 'comment'},
                { name:'close_price',title:'Close Price', data: 'close_price'},
                { name:'close_time',title:'Close Time', data: 'close_time'},
                { name:'commission',title:'Commission', data: 'commission'},
                { name:'swap',title:'Swap', data: 'swap'},
                { name:'share_percentage',title:'Share Percentage', data: 'share_percentage'},
                { name:'share_date',title:'Share Datetime', data: 'share_date'},
                { name:'total_profit',title:'Total Profit', data: 'total_profit'},
                { name:'total_attached',title:'Total Attached', data: 'total_attached'},
                { title:'Datetime', name:'created_at', data: 'created_at'},
                { title:'status', name:'status', data: 'status'},
                { title:'action', name:'action', data: 'action'},
			]
		});

        window.addEventListener('refreshdatatable', event => {
            dataTable.draw(true);
        });
	});
</script>
@endpush
