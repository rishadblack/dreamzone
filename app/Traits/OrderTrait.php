<?php

namespace App\Traits;

trait OrderTrait
{
    public function scopeSumOrder($query, $data = [])
    {
        return $query->withSum(['Order as total_order_amount' => function ($query) {
            $query->paid();
        }], 'net_amount')->withSum(['Order as total_order_point' => function ($query) {
            $query->paid();
        }], 'point')->withCount('Order as total_order_count');
    }
}
