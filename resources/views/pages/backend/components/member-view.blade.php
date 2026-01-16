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
                    @endif
                </div>
                <div class="col-md-6">
                    Team A Point: {{ pointFormat($memberTree->l_premium, true) }}<br />
                    Team B Point : {{ pointFormat($memberTree->c_premium, true) }}<br />
                    Team A Member: {{ abs($memberTree->l_premium) }}<br />
                    Team B Member : {{ abs($memberTree->c_premium) }}<br />
                </div>
            </div>
        @endif
    </x-modal>
</div>
