<?php

namespace App\Traits;

trait StockTrait
{
    public function scopeSumStock($query, $data = [])
    {
        $productId = isset($data['product_id']) ? $data['product_id'] : null;
        $dealerId = isset($data['dealer_id']) ? $data['dealer_id'] : null;
        $status = isset($data['status']) ? $data['status'] : null;

        return $query->withSum(['orderItem as stock_in' => function ($query) use ($productId, $dealerId, $status) {
            if ($productId) {
                $query->where('product_id', $productId);
            }

            if ($dealerId) {
                $query->where('dealer_id', $dealerId);
            }

            $query->in()->active();
        }], 'quantity')->withSum(['orderItem as stock_out' => function ($query) use ($productId, $dealerId, $status) {
            if ($productId) {
                $query->where('product_id', $productId);
            }

            if ($dealerId) {
                $query->where('dealer_id', $dealerId);
            }

            if ($status) {
                $query->active();
            }

            $query->out();
        }], 'quantity');
    }

    public function getAvailableStockAttribute()
    {
        return $this->stock_in - $this->stock_out;
    }

    public function getCheckAvailableStockAttribute()
    {
        return ($this->stock_in - $this->stock_out) > 0 ? true : false;
    }
}
