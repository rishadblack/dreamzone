<?php

namespace App\Traits;

trait FundTrait
{
    public function scopeSumFund($query, $data = [])
    {
        $startDate = isset($data['start_date']) ? $data['start_date'] : null;
        $endDate = isset($data['end_date']) ? $data['end_date'] : null;

        return $query->withSum(['Fund as total_attached' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('funds.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('funds.created_at', '<=', $endDate);
            }

            $query->whereNotNull('is_attached')->whereNull('is_detached_request');
        }], 'attached_amount')
        ->withSum(['Fund as total_attached_request' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('funds.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('funds.created_at', '<=', $endDate);
            }

            $query->whereNotNull('is_attached_request')->whereNull('is_attached')->whereNull('is_detached_request');
        }], 'net_amount')
        ->withSum(['Fund as total_detached' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('funds.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('funds.created_at', '<=', $endDate);
            }

            $query->whereNotNull('is_attached_request');
        }], 'attached_amount');
    }
}
