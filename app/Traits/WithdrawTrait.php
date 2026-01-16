<?php

namespace App\Traits;

trait WithdrawTrait
{
    public function scopeSumWithdraw($query, $data = [])
    {
        $startDate = isset($data['start_date']) ? $data['start_date'] : null;
        $endDate = isset($data['end_date']) ? $data['end_date'] : null;

        $query->withSum(['Withdrawal as total_withdraw' => function ($q) use ($startDate,$endDate) {
            if ($startDate) {
                $q->whereDate('withdrawals.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $q->whereDate('withdrawals.created_at', '<=', $endDate);
            }

            $q->where('status', '!=', 3);
        }], 'amount');

        $query->withSum(['Withdrawal as total_charge' => function ($q) use ($startDate,$endDate) {
            if ($startDate) {
                $q->whereDate('withdrawals.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $q->whereDate('withdrawals.created_at', '<=', $endDate);
            }

            $q->where('status', '!=', 3);
        }], 'charge');

        $query->withSum(['Withdrawal as total_paid' => function ($q) use ($startDate,$endDate) {
            if ($startDate) {
                $q->whereDate('withdrawals.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $q->whereDate('withdrawals.created_at', '<=', $endDate);
            }

            $q->whereStatus(1);
        }], 'amount');

        $query->withSum(['Withdrawal as total_pending' => function ($q) use ($startDate,$endDate) {
            if ($startDate) {
                $q->whereDate('withdrawals.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $q->whereDate('withdrawals.created_at', '<=', $endDate);
            }

            $q->whereStatus(2);
        }], 'amount');

        return $query;
    }

    public function scopeSumAvailableIncomeBalance($query, $data = [])
    {
        $startDate = isset($data['start_date']) ? $data['start_date'] : null;
        $endDate = isset($data['end_date']) ? $data['end_date'] : null;

        $query->withSum(['Withdrawal as total_withdraw' => function ($q) use ($startDate,$endDate) {
            if ($startDate) {
                $q->whereDate('withdrawals.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $q->whereDate('withdrawals.created_at', '<=', $endDate);
            }

            $q->where('status', '!=', 3);
        }], 'amount');

        $query->withSum(['Income as total_income' => function ($q) use ($startDate,$endDate) {
            if ($startDate) {
                $q->whereDate('incomes.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $q->whereDate('incomes.created_at', '<=', $endDate);
            }

            $q->whereStatus(1);
        }], 'net_amount');

        return $query;
    }

    public function getAvailableIncomeBalanceAttribute()
    {
        return $this->total_income - $this->total_withdraw;
    }
}
