<div {{ $attributes->merge(['class' => 'text-center border ']) }}>
    <img src="{{ URL::asset('images/male-icon.png')}}" width="100" alt="" class="mx-auto avatar-md img-thumbnail rounded-circle">
    <br />
    <button type="button"  x-data @click="$dispatch('eventCallFunc',{callName:'openMemberTreeRegisterModal',placement_id:'{{$attributes['placement_id']}}',placement_team:'{{$attributes['placement_team']}}'})" class="mt-1 mb-1 btn btn-sm btn-success">Register</button>
</div>
