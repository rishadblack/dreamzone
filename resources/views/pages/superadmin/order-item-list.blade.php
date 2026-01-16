<div>
    <x-slot name="title">
        Account Balance Generate
    </x-slot>
    <div class="container-fluid dashboard-default-sec">
        <div class="row starter-main">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="pb-0 card-header">
                        <h5 class="float-left card-title">Account Balance Generate List</h5>
                        <div class="pt-0 bookmark">
                            <button class="mt-1 btn btn-primary" type="button" wire:click="openBalanceGenerateModal">Generate Balance</button>
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
                    <div class="card-footer">
                        <button class="btn btn-primary" type="button" wire:click="storeProfileUpdate">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <x-modal id="BalanceGenerateModal" title="Generate balance and transfer to user" footer="button">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <x-search.username wire:model.lazy="username" label="To beneficiary/recipient account" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.text wire:model.defer="username_name" label="To beneficiary/recipient full name" read-only="true" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.price wire:model.defer="amount" label="Amount" />
                </div>
                <div class="col-sm-12 col-lg-12">
                    <x-input.textarea wire:model.defer="note" label="Remark" placeholder="Optional.." />
                </div>
            </div>
            <x-slot name="footer">
                <x-button.default class="btn btn-success" type="button" wire:click="storeBalanceGenerate" wire:target="storeBalanceGenerate">Submit</x-button.default>
            </x-slot>
        </x-modal>
    </div>
</div>

@push('js')
<script >
        function callView(id) {
            @this.call('openBalanceGenerateModal', id);
        }

	$(document).ready(function(){
		var dataTable = $('#reportTable').DataTable({
			processing: true,
			serverSide: true,
            order: [[ 0, "desc" ]],
			ajax: "{{route('superadmin.datatable',['table' => 'generateBalanceDatatable'])}}",
			columns: [
                { title:'ID', data: 'id' },
                { title:'Name', name: 'User.name', data: 'user.name'},
                { title:'User Id',name: 'User.username', data: 'user.username'},
                { title:'Amount',name:'amount', data: 'amount'},
                { title:'Note',name:'note', data: 'note'},
                { title:'Datetime',name:'created_at', data: 'created_at'},
                { title:'status',name:'status', data: 'status'},
                { title:'action',name:'action', data: 'action'},
			]
		});

        window.addEventListener('refreshdatatable', event => {
            dataTable.draw(true);
        });
	});
</script>
@endpush
