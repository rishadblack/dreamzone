<?php

namespace App\Pages\Superadmin;

use App\Models\Fund;
use App\Models\Order;
use App\Models\Point;
use App\Models\Dealer;
use App\Models\Income;
use App\Models\Balance;
use App\Http\Common\Component;
use App\Models\MemberTree;
use App\Models\Withdrawal;
use App\Traits\DateRangeTrait;

class Dashboard extends Component
{
    use DateRangeTrait;

    public $date_filter;

    public function updated()
    {
        $this->getUpdate();
    }

    public function getUpdate()
    {
        $MemberTree = MemberTree::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date);
        $MemberTree->selectRaw('(COALESCE(COUNT(id), 0)) AS `new_register`');
        $MemberTree->selectRaw('(COALESCE(COUNT(CASE WHEN `incentive_id` IS NOT NULL THEN id END), 0)) AS `achiever`');
        $MemberTree->selectRaw('(COALESCE(COUNT(CASE WHEN `is_premium` IS NOT NULL THEN id END), 0)) AS `premium_member`');
        $MemberTree->selectRaw('(COALESCE(COUNT(CASE WHEN `is_founder` IS NOT NULL THEN id END), 0)) AS `founder_member`');
        $MemberTree->selectRaw('(COALESCE(COUNT(CASE WHEN `is_super_founder` IS NOT NULL THEN id END), 0)) AS `super_founder_member`');
        $MemberTree->selectRaw('(COALESCE(COUNT(CASE WHEN `is_super_dealer` IS NOT NULL THEN id END), 0)) AS `super_dealer_member`');
        $MemberTree->selectRaw('(COALESCE(sum(`total_matching`), 0)) AS `total_matching`');
        $MemberTree->selectRaw('(COALESCE(sum(`paid_matching`), 0)) AS `paid_matching`');
        $MemberTree->selectRaw('(COALESCE(sum(`flash_matching`), 0)) AS `flash_matching`');

        foreach (config('mlm.incentives') as $key => $value) {
            $MemberTree->selectRaw("(COALESCE(COUNT(CASE WHEN `incentive_id` = '".$key."' THEN id END), 0)) AS `total_".$value['name'].'`');
        }

        $MemberTree = $MemberTree->first();

        $MemberTree->dealer_member = Dealer::whereType(2)->whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date)->count();

        $Balance = Balance::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date);
        $Balance->selectRaw("(COALESCE(sum(CASE WHEN `flow` = '1' THEN `amount` END), 0)) AS `balance_in`");
        $Balance->selectRaw("(COALESCE(sum(CASE WHEN `flow` = '2' THEN `amount` END), 0)) AS `balance_out`");
        $Balance->selectRaw("(COALESCE(sum(CASE WHEN `flow` = '2' AND `type` = 2 THEN `amount` END), 0)) AS `balance_generate`");
        $Balance = $Balance->first();

        $Withdrawal = Withdrawal::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date);
        $Withdrawal->selectRaw('(COALESCE(sum(CASE WHEN `status` = 1 THEN `amount` END), 0)) AS `total_paid`');
        $Withdrawal->selectRaw('(COALESCE(sum(CASE WHEN `status` = 1 THEN `charge` END), 0)) AS `total_charge`');
        $Withdrawal->selectRaw('(COALESCE(sum(CASE WHEN `status` = 2 THEN `amount` END), 0)) AS `total_due`');
        $Withdrawal->selectRaw('(COALESCE(sum(CASE WHEN `status` = 3 THEN `amount` END), 0)) AS `total_cancel`');
        $Withdrawal->selectRaw('(COALESCE(sum(`amount`), 0)) AS `total_withdrawal`');
        $Withdrawal = $Withdrawal->first();

        $Point = Point::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date);
        $Point->selectRaw('(COALESCE(sum(CASE WHEN `type` = 2 AND `flow` = 2 THEN `value` END), 0)) AS `total_upgrade`');
        $Point->selectRaw('(COALESCE(sum(CASE WHEN `type` = 1 AND `flow` = 1 THEN `value` END), 0)) AS `total_order`');
        $Point->selectRaw('(COALESCE(sum(CASE WHEN `type` = 6 AND `flow` = 1 THEN `value` END), 0)) AS `total_generate`');
        $Point->selectRaw('(COALESCE(SUM(CASE WHEN `flow` = 1 THEN value END), 0)) - (COALESCE(SUM(CASE WHEN `flow` = 2 THEN value END), 0)) AS `total`');
        $Point = $Point->first();

        // $Order = Order::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date);
        // $Order->selectRaw("(COALESCE(sum(CASE WHEN `payment_status` = 'Paid' THEN `net_amount` END), 0)) AS `total_paid`");
        // $Order->selectRaw("(COALESCE(sum(CASE WHEN `payment_status` = 'Due' THEN `net_amount` END), 0)) AS `total_due`");
        // $Order->selectRaw('(COALESCE(sum(`net_amount`), 0)) AS `total`');
        // $Order = $Order->first();

        $Income = Income::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date);
        foreach (config('mlm.income_list') as $key => $income) {
            $Income->selectRaw("(COALESCE(SUM(CASE WHEN `type` = '".$income['income_type']."' THEN net_amount END), 0)) AS `".$income['name'].'_income`');
        }
        $Income->selectRaw('(COALESCE(sum(CASE WHEN `type` != 9  AND `flow` = 1 THEN `net_amount` END), 0)) AS `total_income`');

        $Income = $Income->first();

        $Fund = Fund::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date);
        $Fund->selectRaw('(COALESCE(SUM(CASE WHEN `is_attached_request` IS NOT NULL AND `is_attached` IS NULL  THEN net_amount END), 0)) AS `attached_request_fund`');
        $Fund->selectRaw('(COALESCE(SUM(CASE WHEN `is_attached` IS NOT NULL AND `is_detached_request` IS NULL  THEN net_amount END), 0)) AS `attached_fund`');
        $Fund->selectRaw('(COALESCE(SUM(CASE WHEN `is_detached_request` IS NOT NULL AND `is_detached` IS NULL  THEN net_amount END), 0)) AS `detached_request_fund`');
        $Fund->selectRaw('(COALESCE(SUM(CASE WHEN `is_detached` IS NOT NULL THEN net_amount END), 0)) AS `detached_fund`');
        $Fund = $Fund->first();

        return [
            'MemberTree' => $MemberTree,
            'Income' => $Income,
            'Balance' => $Balance,
            'Withdrawal' => $Withdrawal,
            'Fund' => $Fund,
            'Point' => $Point,
            // 'order' => $Order,
        ];
    }

    public function render()
    {
        return view('pages.superadmin.dashboard', [
            'data' => $this->getUpdate(),
        ])->layout('layouts.backend-layout');
    }
}
