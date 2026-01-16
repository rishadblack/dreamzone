<div class="media align-items-center mt-0" style="width:250px">
    <img class="avatar shadow avatar-md me-3 br-4" src="{{$member ? $member->User->profile_url : asset('images/male-icon.png') }}" @click="$dispatch('eventCallFunc',{callName:'openMemberViewModal',id:'{{ $member ? $member->user_id : null }}'})" alt="avatar-img">
    <div class="media-body valign-middle mt-0">
        <a href="javascript:void(0);" class="text-dark fw-semibold">{{$member ? $member->User->username : 'Empty'}}</a>
        <p class="text-muted mb-0 fs-13">{{$member ? $member->User->name : ''}}</p>
    </div>
    <div class="media-body valign-middle text-end">
        <x-button.default class="btn btn-{{ $member ? ( $member->is_premium ? 'success' : 'danger') : 'gray'}}" wire:click="getTeam({{$member ? $member->user_id : null}})" wire:target="getTeam">{{$member ? $member->total_member : 0 }}</x-button.default>
    </div>
</div>
