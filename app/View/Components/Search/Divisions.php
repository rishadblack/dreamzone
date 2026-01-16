<?php

namespace App\View\Components\Search;

use App\Models\Division;
use Illuminate\View\Component;

class Divisions extends Component
{
    public $countryId;

    public function __construct(int $countryId = null)
    {
        $this->countryId = $countryId;
    }

    public function render()
    {
        $Divisions = Division::query();

        if ($this->countryId) {
            $Divisions->whereCountryId($this->countryId);
        }

        return view('components.search.divisions',[
            "divisions" => $Divisions->orderBy('name')->get()
        ]);
    }
}