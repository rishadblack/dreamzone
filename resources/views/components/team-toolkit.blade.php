<div
    {{ $attributes->merge(['class' => 'text-center border ' . ($teamMember->is_premium ? ($teamMember->is_cashback ? ' border-warning ' : ' border-success ') : ' border-danger ')]) }}>
    <img src="{{ $teamMember->User->profile ? asset_storage($teamMember->User->profile) : asset('images/male-icon.png') }}?v=1"
        width="100px" height="100px" alt="{{ $teamMember->User->username }}" x-data
        @click="$dispatch('eventCallFunc',{callName:'getTeam',id:'{{ $teamMember->user_id }}'})"
        class="mx-auto avatar-md img-thumbnail rounded-circle" />
    <br />
    <button x-data @click="$dispatch('eventCallFunc',{callName:'openMemberViewModal',id:'{{ $teamMember->id }}'})"
        class="mt-1 mb-1 badge {{ $teamMember->is_cashback ? ' bg-warning ' : ' bg-success ' }}"">{{ $teamMember->User->username }}</span>
</div>
