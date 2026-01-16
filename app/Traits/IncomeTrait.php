<?php

namespace App\Traits;

trait IncomeTrait
{
    public function scopeSumIncome($query, $data = [])
    {
        $startDate = isset($data['start_date']) ? $data['start_date'] : null;
        $endDate = isset($data['end_date']) ? $data['end_date'] : null;
        $walletType = isset($data['wallet_type']) ? $data['wallet_type'] : null;
        $onlyIncome = isset($data['only_income']) ? $data['only_income'] : false;

        $query->withSum(['Income as total_income' => function ($query) use ($startDate, $endDate, $walletType) {
            if ($startDate) {
                $query->whereDate('incomes.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('incomes.created_at', '<=', $endDate);
            }

            if ($walletType) {
                $query->whereWalletType($walletType);
            }

            $query->whereFlow(1)->whereStatus(1)->where('incomes.type', '!=', 9);
        }], 'net_amount');

        if(!$onlyIncome) {
            foreach (config('mlm.income_list') as $key => $value) {
                $query->withSum(['Income as ' . $value['name'] . '_income' => function ($q) use ($startDate, $endDate, $value) {
                    if ($startDate) {
                        $q->whereDate('incomes.created_at', '>=', $startDate);
                    }

                    if ($endDate) {
                        $q->whereDate('incomes.created_at', '<=', $endDate);
                    }

                    $q->whereType($value['income_type'])->whereFlow(1)->whereStatus(1);
                }], 'net_amount');
            }
        }

        $query->withSum(['Income as income_in' => function ($query) use ($startDate, $endDate, $walletType) {
            if ($startDate) {
                $query->whereDate('incomes.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('incomes.created_at', '<=', $endDate);
            }

            if ($walletType) {
                $query->whereWalletType($walletType);
            }

            $query->whereFlow(1)->whereStatus(1);
        }], 'net_amount')
        ->withSum(['Income as income_out' => function ($query) use ($startDate, $endDate, $walletType) {
            if ($startDate) {
                $query->whereDate('incomes.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('incomes.created_at', '<=', $endDate);
            }

            if ($walletType) {
                $query->whereWalletType($walletType);
            }

            $query->whereFlow(2)->whereStatus(1);
        }], 'net_amount');


        return $query;
    }

    public function scopeSumIncomeType($query, $data = [])
    {
        $startDate = isset($data['start_date']) ? $data['start_date'] : null;
        $endDate = isset($data['end_date']) ? $data['end_date'] : null;
        $walletType = isset($data['wallet_type']) ? $data['wallet_type'] : null;
        $value = isset($data['income_type']) ? config('mlm.income_list.' . $data['income_type']) : false;

        $query->withSum(['Income as ' . $value['name'] . '_income' => function ($q) use ($startDate, $endDate, $walletType, $value) {
            if ($startDate) {
                $q->whereDate('incomes.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $q->whereDate('incomes.created_at', '<=', $endDate);
            }

            if ($walletType) {
                $q->whereWalletType($walletType);
            }

            $q->whereType($value['income_type'])->whereFlow(1)->whereStatus(1);
        }], 'net_amount');


        return $query;
    }

    public function getAvailableIncomeAttribute()
    {
        return $this->income_in - $this->income_out;
    }

    public function getCheckAvailableIncomeAttribute()
    {
        return ($this->income_in - $this->income_out) > 0 ? true : false;
    }
}
