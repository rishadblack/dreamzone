<?php

namespace App\View\Components\Search;

use App\Models\District;
use Illuminate\View\Component;

class Districts extends Component
{
    public $divisionId;

    public function __construct(int $divisionId = null)
    {
        $this->divisionId = $divisionId;
    }

    public function render()
    {
        $Districts = District::query();

        if ($this->divisionId) {
            $Districts->whereDivisionId($this->divisionId);
        }

        return view('components.search.districts',[
            "districts" => $Districts->orderBy('name')->get()
        ]);
    }
}