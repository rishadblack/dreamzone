<?php

namespace App\View\Components\Search;

use App\Models\Upazila;
use Illuminate\View\Component;

class Upazilas extends Component
{
    public $districtId;

    public function __construct(int $districtId = null)
    {
        $this->districtId = $districtId;
    }

    public function render()
    {
        $Upazila = Upazila::query();

        if ($this->districtId) {
            $Upazila->whereDistrictId($this->districtId);
        }

        return view('components.search.upazilas',[
            "upazilas" => $Upazila->orderBy('name')->get()
        ]);

    }
}