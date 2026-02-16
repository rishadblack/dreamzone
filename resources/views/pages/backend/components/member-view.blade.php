<div>
    <x-modal id="MemberViewModal" title="{{ $memberTree ? $memberTree->User->name : null }} Account Details"
        footer="button">
        @if ($memberTree)
            <div class="row">
                <div class="col-md-6">
                    Name : {{ $memberTree->User->name }}<br />
                    Refer By : {{ $memberTree->sponsor_id ? $memberTree->bySponsor->username : 'System' }}<br />
                    Register Date : {{ Carbon\Carbon::parse($memberTree->created_at)->format('d M Y') }}<br />
                    Rank : @if ($memberTree->designation_plan)
                        {{ config('mlm.incentives.' . $memberTree->designation_plan . '.title') }}
                    @else
                        Member
                    @endif <br />
                    Step : @if ($memberTree->designation_plan)
                        {{ config('mlm.incentives.' . $memberTree->designation_plan . '.title') }}
                    @else
                        -
                    @endif
                </div>
                <div class="col-md-6">
                    Personal Point : {{ pointFormat($memberTree->p_point, true) }}<br />
                    Refer Point : {{ pointFormat($refer_point, true) }}<br />
                    Sales Point 1 : {{ pointFormat($memberTree->l_point, true) }}<br />
                    Sales Point 2 : {{ pointFormat($memberTree->r_point, true) }}<br />
                    Carry Point :
                    {{ pointFormat(abs($memberTree->l_point - $memberTree->r_point), true) }}<br />
                    Sales 1 Member: {{ abs($memberTree->l_member) }}<br />
                    Sales 2 Member: {{ abs($memberTree->r_member) }}<br />
                </div>
            </div>
        @endif
    </x-modal>
</div>
