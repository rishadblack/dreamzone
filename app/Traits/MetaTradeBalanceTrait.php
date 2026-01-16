<?php

namespace App\Traits;

trait MetaTradeBalanceTrait
{
    public function scopeSumMetaTradeBalance($query, $data = [])
    {
        $startDate = isset($data['start_date']) ? $data['start_date'] : null;
        $endDate = isset($data['end_date']) ? $data['end_date'] : null;

        return $query->withSum(['metaTradeBalance as mt_balance_in' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('mate_trade_balances.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('mate_trade_balances.created_at', '<=', $endDate);
            }

            $query->whereFlow(1);
        }], 'amount')
        ->withSum(['metaTradeBalance as mt_balance_out' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('mate_trade_balances.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('mate_trade_balances.created_at', '<=', $endDate);
            }

            $query->whereFlow(2);
        }], 'amount')
        ->withSum(['metaTradeBalance as total_return' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('mate_trade_balances.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('mate_trade_balances.created_at', '<=', $endDate);
            }

            $query->whereFlow(1)->whereType(5);
        }], 'amount')
        ->withSum(['metaTradeBalance as total_profit_share' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('mate_trade_balances.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('mate_trade_balances.created_at', '<=', $endDate);
            }

            $query->whereFlow(1)->whereType(6);
        }], 'amount');
    }

    public function getAvailableMtBalanceAttribute()
    {
        return $this->mt_balance_in - $this->mt_balance_out;
    }

    public function getCheckAvailableMtBalanceAttribute()
    {
        return ($this->mt_balance_in - $this->mt_balance_out) > 0 ? true : false;
    }
}
