<div class="btn-group me-2">
    <button type="button"
        class="btn btn-radius btn-outline-{{ $member ? ($member->is_premium ? 'success' : 'danger') : 'info' }}"><img
            class="avatar shadow  avatar-sm"
            @click="$dispatch('eventCallFunc',{callName:'openMemberViewModal',id:'{{ $member ? $member->user_id : null }}'})"
            src="{{ $member ? $member->User->profile_url : asset('images/male-icon.png') }}" alt="avatar-img"></button>
    <button type="button"
        class="btn btn-outline-{{ $member ? ($member->is_premium ? 'success' : 'danger') : 'info' }}">{{ $member ? $member->User->username : 'Empty' }}</button>
    <button type="button" class="btn btn-{{ $member ? ($member->is_premium ? 'success' : 'danger') : 'gray' }}"
        wire:click="getTeam({{ $member ? $member->user_id : null }})" wire:target="getTeam">
        {{ $member ? $member->total_member : 0 }}
    </button>
</div>
