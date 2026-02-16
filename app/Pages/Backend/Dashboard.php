<?php
namespace App\Pages\Backend;

use App\Http\Common\Component;
use App\Models\Balance;
use App\Models\Income;
use App\Models\MemberTree;
use App\Models\Order;
use App\Models\Point;
use App\Models\User;
use App\Models\Withdrawal;
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
        if (setting('show_notic') == 'Y') {
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
        $TotalOrder = Order::whereUserId(Auth::id())->wherePaymentStatus(1)->sum('net_amount');
        $TotalOrderDiscount = Order::whereUserId(Auth::id())->wherePaymentStatus(1)->sum('discount_amount');
        $TotalSponsor = MemberTree::whereSponsorId(Auth::id())->count();

        return view('pages.backend.dashboard', [
            'User' => User::totalIncomes()->find(Auth::id()),
            'Point' => $Point,
            'Balance' => $Balance,
            'Income' => $Income,
            'TotalIncome' => $TotalIncome,
            'TotalWithdrawal' => $TotalWithdrawal,
            'TotalSponsor' => $TotalSponsor,
            'TotalOrder' => $TotalOrder,
            'TotalOrderDiscount' => $TotalOrderDiscount,
        ]);
    }
}