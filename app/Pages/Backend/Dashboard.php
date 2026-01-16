<?php

namespace App\Pages\Backend;

use App\Models\Fund;
use App\Models\User;
use App\Models\Point;
use App\Models\Income;
use App\Models\Balance;
use App\Http\Common\Component;
use App\Models\MemberTree;
use App\Models\Withdrawal;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Dashboard extends Component
{
    use LivewireAlert;

    public $ref_url;

    public function mount()
    {
        $this->ref_url = route('register', ['ref' => Auth::user()->username]);
    }

    public function rendered()
    {
        if(setting('show_notic') == 'Y') {
            $this->dispatch('modalOpen', 'NoticModal');
        }
    }

    public function render()
    {
        $Balance = Balance::availableBalance()->whereUserId(Auth::id())->whereStatus(1)->whereWalletType(1)->first();
        $Point = Point::availablePoint()->whereUserId(Auth::id())->whereStatus(1)->first();
        $Income = Income::availableIncome()->whereUserId(Auth::id())->whereWalletType(1)->whereStatus(1)->first();
        $TotalIncome = Income::whereFlow(1)->whereUserId(Auth::id())->whereWalletType(1)->sum('amount');
        $TotalWithdrawal = Withdrawal::whereUserId(Auth::id())->whereStatus(1)->sum('amount');
        $TotalAttach = Fund::whereUserId(Auth::id())->whereNotNull('is_attached')->whereNull('is_detached_request')->whereStatus(1)->sum('attached_amount');


        $TotalSponsor = MemberTree::whereSponsorId(Auth::id())->count();

        return view('pages.backend.dashboard', [
            'User' => User::totalIncomes()->find(Auth::id()),
            'Point' => $Point,
            'Balance' => $Balance,
            'Income' => $Income,
            'TotalIncome' => $TotalIncome,
            'TotalWithdrawal' => $TotalWithdrawal,
            'TotalSponsor' => $TotalSponsor,
            'TotalAttach' => $TotalAttach,
        ]);
    }
}
