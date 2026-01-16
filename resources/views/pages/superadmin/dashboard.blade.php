<div>
    <x-slot name="title"> Dashboard </x-slot>
    <x-slot name="card_title"> Superadmin Dashboard </x-slot>

    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <x-input.date-range wire:model="date_filter" label="Date Filter" />
        </div>
    </div>
    <div class="mt-3 row">
        <div class="col-sm-6 col-lg-4">
            <div class="p-1 border">
                <h6 >Member</h6>
                Total Register : {{$data['MemberTree']['new_register']}}<br/>
                Total Premium : {{$data['MemberTree']['premium_member']}}<br/>
                Total Achiever : {{$data['MemberTree']['achiever']}}<br/>
                Total Dealer : {{$data['MemberTree']['dealer_member']}}<br/>
                Total Founder : {{$data['MemberTree']['founder_member']}}<br/>
                Total Super Founder : {{$data['MemberTree']['super_founder_member']}}<br/>
                Total Super Dealer : {{$data['MemberTree']['super_dealer_member']}}<br/>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="p-1 border">
                <h6 >Achiever</h6>
                @foreach (config('mlm.incentives') as $item)
                {{$item['title']}} :  {{$data['MemberTree']['total_'.$item['name']]}}<br/>
                @endforeach
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="p-1 border">
                <h6 >Bonus</h6>
                Total Bonus : {{numberFormat($data['Income']['total_income'] , true)}}<br/>
                @foreach (config('mlm.income_list') as $item)
                {{$item['title']}} :  {{numberFormat($data['Income'][$item['name'].'_income'] , true)}}<br/>
                @endforeach
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="p-1 border">
                <h6 >Balance</h6>
                Available Balance : {{numberFormat($data['Balance']['balance_in'] - $data['Balance']['balance_out'] , true)}}<br/>
                Generated Balance : {{numberFormat($data['Balance']['balance_generate'] , true)}}<br/>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="p-1 border">
                <h6 >Point</h6>
                    Available Point: {{pointFormat($data['Point']['total'] , true)}}<br/>
                    Upgrade Point: {{pointFormat($data['Point']['total_upgrade'] , true)}}<br/>
                    Order Point: {{pointFormat($data['Point']['total_order'] , true)}}<br/>
                    Admin Generate Point: {{pointFormat($data['Point']['total_generate'] , true)}}<br/>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="p-1 border">
                <h6 >Withdrawal</h6>
                Total Withdrawal : {{numberFormat($data['Withdrawal']['total_withdrawal'], true)}}<br/>
                Total Paid : {{numberFormat($data['Withdrawal']['total_paid'], true)}}<br/>
                Total Due : {{numberFormat($data['Withdrawal']['total_due'], true)}}<br/>
                Total Cancel : {{numberFormat($data['Withdrawal']['total_cancel'], true)}}<br/>
                Total Charge : {{numberFormat($data['Withdrawal']['total_charge'], true)}}<br/>
            </div>
        </div>
    </div>

</div>

@push('js')
<script >

</script>
@endpush
