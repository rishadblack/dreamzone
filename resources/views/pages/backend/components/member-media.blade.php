<div class="media overflow-visible align-items-center mt-0 ">
    <img class="avatar shadow  avatar-md me-3 br-4" src="{{ asset(config('mlm.default_profile')) }}?v=1" alt="avatar-img">
    <div class="media-body valign-middle mt-0">
        <a href="javascript:void(0);"
            class="text-dark fw-semibold">{{ $member_tree ? $member_tree->User->username : 'Empty' }}</a>
        <p class="text-muted mb-0 fs-13">{{ $member_tree ? $member_tree->User->name : '' }}</p>
    </div>
    <div class="media-body valign-middle text-end overflow-visible">
        <button class="btn btn-primary btn-sm"
            type="button">{{ $member_tree ? $member_tree->total_member : 0 }}</button>
    </div>
</div>
