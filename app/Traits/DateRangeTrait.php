<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateRangeTrait
{
    public $date_filter;
    public $start_date;
    public $end_date;

    public function updatedDateFilter()
    {
        $date_filter = explode(' to ', $this->date_filter);
        $this->start_date = isset($date_filter[0]) ? Carbon::parse($date_filter[0]) : now();
        $this->end_date = isset($date_filter[1]) ? Carbon::parse($date_filter[1]) : now();
    }

    public function getDateFilter($query)
    {
        return $query->when($this->date_filter, fn ($query) => $query->dateFilter($this->start_date, $this->end_date));
    }

    public function getDateFilterExportHeaterText($headerText)
    {
        if ($this->date_filter) {
            if ($this->start_date && $this->end_date) {
                return array_merge($headerText, [
                    now()->parse($this->start_date)->format(getTimeFormat()).' to '.now()->parse($this->end_date)->format(getTimeFormat()),
                ]);
            } elseif ($this->start_date) {
                return array_merge($headerText, [
                    now()->parse($this->start_date)->format(getTimeFormat()),
                ]);
            } elseif ($this->end_date) {
                return array_merge($headerText, [
                    now()->parse($this->end_date)->format(getTimeFormat()),
                ]);
            }
        }

        return $headerText;
    }

    public function mountDateRangeTrait()
    {
        $this->date_filter = now()->subDays(30)->format(getTimeFormat()).' to '.now()->format(getTimeFormat());
        $date_filter = explode(' to ', $this->date_filter);
        $this->start_date = isset($date_filter[0]) ? Carbon::parse($date_filter[0]) : now();
        $this->end_date = isset($date_filter[1]) ? Carbon::parse($date_filter[1]) : now();
    }
}
