<?php

namespace App\Traits;

trait BalanceTrait
{
    public function scopeSumBalance($query, $data = [])
    {
        $startDate = isset($data['start_date']) ? $data['start_date'] : null;
        $endDate = isset($data['end_date']) ? $data['end_date'] : null;

        return $query->withSum(['Balance as balance_in' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('balances.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('balances.created_at', '<=', $endDate);
            }

            $query->whereFlow(1)->whereStatus(1);
        }], 'amount')
        ->withSum(['Balance as balance_out' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('balances.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('balances.created_at', '<=', $endDate);
            }

            $query->whereFlow(2)->whereStatus(1);
        }], 'amount');
    }

    public function getAvailableBalanceAttribute()
    {
        return $this->balance_in - $this->balance_out;
    }

    public function getCheckAvailableBalanceAttribute()
    {
        return ($this->balance_in - $this->balance_out) > 0 ? true : false;
    }
}
