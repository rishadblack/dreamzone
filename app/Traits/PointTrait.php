<?php

namespace App\Traits;

trait PointTrait
{
    public function scopeSumPoint($query, $data = [])
    {
        $startDate = isset($data['start_date']) ? $data['start_date'] : null;
        $endDate = isset($data['end_date']) ? $data['end_date'] : null;

        return $query->withSum(['Point as point_in' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('points.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('points.created_at', '<=', $endDate);
            }

            $query->whereFlow(1)->whereStatus(1);
        }], 'value')
        ->withSum(['Point as point_out' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('points.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('points.created_at', '<=', $endDate);
            }

            $query->whereFlow(2)->whereStatus(1);
        }], 'value');
    }

    public function scopeSumUpgradedPoint($query, $data = [])
    {
        $startDate = isset($data['start_date']) ? $data['start_date'] : null;
        $endDate = isset($data['end_date']) ? $data['end_date'] : null;

        return $query->withSum(['Point as upgraded_point' => function ($query) use ($startDate,$endDate) {
            if ($startDate) {
                $query->whereDate('points.created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('points.created_at', '<=', $endDate);
            }

            $query->whereFlow(2)->whereType(2)->whereStatus(1);
        }], 'value');
    }

    public function getAvailablePointAttribute()
    {
        return $this->point_in - $this->point_out;
    }

    public function getCheckAvailablePointAttribute()
    {
        return ($this->point_in - $this->point_out) > 0 ? true : false;
    }
}
