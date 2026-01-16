<div class="btn-group me-2">
    <button type="button" class="btn btn-radius btn-outline-{{ $member ? 'primary' : 'gray' }}"><img
            class="avatar shadow  avatar-sm" src="{{ asset(config('mlm.default_profile')) }}?v=1"
            alt="avatar-img"></button>
    <button type="button"
        class="btn btn-outline-{{ $member ? 'primary' : 'gray' }}">{{ $member ? $member->User->username : 'Empty' }}</button>
    <button type="button" class="btn btn-{{ $member ? 'primary' : 'gray' }}">
        {{ $member ? $member->total_member : 0 }}
    </button>
</div>
