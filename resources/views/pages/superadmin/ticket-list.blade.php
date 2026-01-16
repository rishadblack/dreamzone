<div>
    <x-slot name="title"> Ticket List </x-slot>
    <x-slot name="card_title"> Ticket List </x-slot>
    <x-slot name="card_sub_title"> All Ticket List </x-slot>
    <x-slot name="card_action">
        <ul class="nk-block-tools gx-3">
            <li><button type="button" class="btn btn-primary" x-data @click="$dispatch('eventCallFunc',{callName:'openTicketModal'})"><span>New Ticket</span> <em class="icon ni ni-arrow-long-right"></em></button></li>
         </ul>
    </x-slot>
    <div wire:ignore class="table-responsive"> <table id="reportTable" class="table"></table></div>

    <x-modal id="TicketDetailsModal" :title="$title" size="lg">
        <div>
            <div class="bg-white">
                <p class="title d-none d-lg-block">{{$details}}</p>
                <div class="d-none d-lg-block">
                    <ul>
                        <li><span class="label-tag"><em class="icon ni ni-flag-fill"></em> <span>{{config('status.ticket_type.'.$type.'.name')}}</span></span></li>
                        <li><span class="label-tag"><em class="icon ni ni-flag-fill"></em> <span>{{config('status.ticket_status.'.$status.'.name')}}</span></span></li>
                        <li><span class="label-tag"><em class="icon ni ni-flag-fill"></em> <span>{{config('status.ticket_priority.'.$priority.'.name')}}</span></span></li>
                        <li><span class="label-tag"><em class="icon ni ni-flag-fill"></em> <span>{{$created_at ? $created_at->format(getTimeFormat()) : ''}}</span></span></li>
                    </ul>
                </div>
                <hr>
                <div class="nk-msg-reply nk-reply">

                    @if (count($TicketComment) > 0)
                        @foreach ($TicketComment as $comment)
                        <div class="nk-reply-meta">
                            <div class="nk-reply-meta-info"><strong>{{$comment->created_at->format(getTimeFormat())}}</strong></div>
                        </div>
                        <div class="nk-reply-item">
                            <div class="nk-reply-header">
                                <div class="user-card">
                                    <div class="user-avatar sm bg-{{$comment->status == 1 ? 'blud' : 'pink'}}">
                                        <span>{{$comment->status == 1 ? 'M' : 'ST'}}</span>
                                    </div>
                                    <div class="user-name">{{$comment->status == 1 ? $comment->User->name : 'Support Team'}}</div>
                                </div>
                                <div class="date-time">{{$comment->created_at->diffForHumans()}}</div>
                            </div>
                            <div class="nk-reply-body">
                                <div class="nk-reply-entry entry">
                                    <p>{{$comment->msg}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif

                    <div class="nk-reply-form">
                        <div class="nk-reply-form-header">
                            <ul class="nav nav-tabs-s2 nav-tabs nav-tabs-sm">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#reply-form">Reply</a>
                                </li>
                            </ul>
                            <div class="nk-reply-form-title">
                                <div class="title">Reply as: {{auth()->user()->name}}</div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="reply-form">
                                <div class="nk-reply-form-editor">
                                    <div class="nk-reply-form-field">
                                        <x-input.textarea wire:model.defer="message" class="form-control-simple no-resize"/>
                                    </div>
                                    <div class="nk-reply-form-tools">
                                        <ul class="nk-reply-form-actions g-1">
                                            <li class="me-2"><x-button.default class="btn btn-primary float-right" type="button" wire:click="storeTicketComment" wire:target='storeTicketComment'>Reply</x-button.default></li>
                                            <li class="me-2"><x-button.default class="btn btn-success float-right" type="button" wire:click="storeTicketCommentStatus(1)" wire:target='storeTicketCommentStatus'>Solved</x-button.default></li>
                                            <li class="me-2"><x-button.default class="btn btn-danger float-right" type="button" wire:click="storeTicketCommentStatus(6)" wire:target='storeTicketComment'>Cancel</x-button.default></li>
                                        </ul>
                                    </div><!-- .nk-reply-form-tools -->
                                </div><!-- .nk-reply-form-editor -->
                            </div>
                        </div>
                    </div><!-- .nk-reply-form -->
                </div><!-- .nk-reply -->
            </div><!-- .nk-msg-body -->
        </div>
    </x-modal>

    <x-modal id="TicketModal" title="New Ticket" size="lg">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <x-input.text wire:model.defer="title" label="Title" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.select wire:model.defer="type" label="Type" :options="config('status.ticket_type')" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.select wire:model.defer="priority" label="Priority" :options="config('status.ticket_priority')" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.select wire:model.defer="status" label="Status" :options="config('status.ticket_status')" />
            </div>
            <div class="col-sm-12 col-lg-12">
                <x-input.textarea wire:model.defer="details" label="Query"/>
            </div>
        </div>
        <x-slot name="footer">
            <x-button.default class="btn btn-success" type="button" wire:click="storeTicket" wire:target='storeTicket'>Submit</x-button.default>
        </x-slot>
    </x-modal>
</div>

@push('js')
<script>
    $(document).ready(function () {
        window.loadDataTable = loadDatatable('#reportTable',{
            ajax: "{{route('superadmin.datatable',['table' => 'ticketDatatable'])}}",
            columns: [
                {title: 'ID',name: 'id',data: 'id'},
                {title:'Name', name: 'User.name', data: 'user.name' },
                {title:'Username', name: 'User.username', data: 'user.username'},
                {title: 'Title',name: 'title',data: 'title'},
                {title: 'Ticket Date',name: 'created_at',data: 'created_at'},
                {title: 'Type',name: 'type',data: 'type'},
                {title: 'Priority',name: 'priority',data: 'priority'},
                {title: 'Status',name: 'status',data: 'status'},
                {title: 'Action',name: 'action',data: 'action'},
            ]
        });
    });
</script>
@endpush
