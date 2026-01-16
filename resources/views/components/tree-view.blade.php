<div>
    <div class="team">
        @if ($memberTree->User->is_approve)
            <div class="text-black team-status bg-success"><em class="icon ni ni-check-thick"></em></div>
        @else
            <div class="text-black team-status bg-danger"><em class="icon ni ni-na"></em></div>
        @endif
        {{-- <div class="team-options">
            <div class="drodown">
                <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                <div class="dropdown-menu dropdown-menu-end">
                    <ul class="link-list-opt no-bdr">
                        <li><a href="#"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                        <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                        <li><a href="#"><em class="icon ni ni-mail"></em><span>Send Email</span></a></li>
                        <li class="divider"></li>
                        <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                        <li><a href="#"><em class="icon ni ni-shield-off"></em><span>Reset 2FA</span></a></li>
                        <li><a href="#"><em class="icon ni ni-na"></em><span>Suspend User</span></a></li>
                    </ul>
                </div>
            </div>
        </div> --}}
        <div class="user-card user-card-s2">
            <div class="user-avatar md bg-primary">
                <img wire:click="getTreeView({{ $memberTree->user_id }})" src="./images/avatar/a-sm.jpg" alt="">
                <div class="status dot dot-lg dot-success"></div>
            </div>
            <div class="user-info">
                <h6>{{ $memberTree->User->name }}</h6>
                <span class="sub-text">{{ $memberTree->User->username }} @if ($memberTree->designation_plan)
                        (<strong>{{ config('mlm.incentives.' . $memberTree->designation_plan . '.title') }}</strong>)
                    @endif
                </span>
            </div>
        </div>
        <div class="team-details">
            <p>Total Trader's = {{ $memberTree->Sponsor->count() }}</p>
        </div>
        <ul class="team-statistics">
            <li><span>{{ numberFormat($memberTree->p_point, true) }}</span><span>Total Attached</span></li>
            <li><span>{{ numberFormat($memberTree->total_point, true) }}</span><span>Group Attached</span></li>
        </ul>
        @if (!isset($attributes['base']))
            <div class="team-view">
                <button type="button" class="btn btn-round btn-outline-light w-150px"
                    wire:click="getTreeView({{ $memberTree->user_id }})"><span>View Profile</span></button>
            </div>
        @endif
    </div>
</div>
