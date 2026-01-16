<div>
    @if ($teamMember->l_id)
        <div class="block_component" wire:key="compoennt-{{ $teamMemberA->user_id }}">
            <div class="btn-group mb-2" role="group" aria-label="Basic mixed styles example">
                <button type="button" wire:click="next({{ $teamMemberA->user_id }})"
                    class="btn btn-primary fa fa-{{ $load_component ? 'minus' : 'plus' }}"><img class=""
                        src="{{ asset('images/male-icon.png') }}" width="50px" alt="avatar-img"></button>
                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                    title="{{ $teamMemberA->User->name }}">{{ $teamMemberA->User->username }}
                    ({{ pointFormat($teamMemberA->p_point, true) }}) (M
                    {{ abs($teamMemberA->total_member) }})</button>
                <button type="button" class="btn btn-success fa fa-eye" x-data
                    @click="$dispatch('eventCallFunc',{callName:'openMemberViewModal',id:'{{ $teamMemberA->user_id }}'})"></button>
            </div>
            @if (isset($check_load_component[$teamMemberA->user_id]) &&
                    $check_load_component[$teamMemberA->user_id] &&
                    $load_component)
                <livewire:dynamic-component :is="$load_component" :id="$teamMemberA->user_id" :key="$teamMemberA->user_id" />
            @endif
        </div>
    @else
        <div class="block_component" wire:key="compoennt-{{ $teamMember->user_id }}-1">
            <div class="btn-group mb-2" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-warning">Available
                    Team A</button>
                <button type="button" class="btn btn-success fa fa-handshake-o" x-data
                    @click="$dispatch('eventCallFunc',{callName:'openMemberUpgradeModal',id:'{{ $teamMember->user_id }}',team:'a'})"></button>
            </div>
        </div>
    @endif

    @if ($teamMember->r_id)
        <div class="block_component" wire:key="compoennt-{{ $teamMemberB->user_id }}">
            <div class="btn-group mb-2" role="group" aria-label="Basic mixed styles example">
                <button type="button" wire:click="next({{ $teamMemberB->user_id }})"
                    class="btn btn-primary fa fa-{{ $load_component ? 'minus' : 'plus' }}"><img class=""
                        src="{{ asset('images/male-icon.png') }}" width="50px" alt="avatar-img"></button>
                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                    title="{{ $teamMemberB->User->name }}">{{ $teamMemberB->User->username }}
                    ({{ pointFormat($teamMemberB->p_point, true) }}) (M
                    {{ abs($teamMemberB->total_member) }})</button>
                <button type="button" class="btn btn-success fa fa-eye" x-data
                    @click="$dispatch('eventCallFunc',{callName:'openMemberViewModal',id:'{{ $teamMemberB->user_id }}'})"></button>
            </div>
            @if (isset($check_load_component[$teamMemberB->user_id]) &&
                    $check_load_component[$teamMemberB->user_id] &&
                    $load_component)
                <livewire:dynamic-component :is="$load_component" :id="$teamMemberB->user_id" :key="$teamMemberB->user_id" />
            @endif
        </div>
    @else
        <div class="block_component" wire:key="compoennt-{{ $teamMember->user_id }}-b">
            <div class="btn-group mb-2" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-warning">Available
                    Team B</button>
                <button type="button" class="btn btn-success fa fa-handshake-o" x-data
                    @click="$dispatch('eventCallFunc',{callName:'openMemberUpgradeModal',id:'{{ $teamMember->user_id }}',team:'b'})"></button>
            </div>
        </div>
    @endif

</div>
