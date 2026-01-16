<?php

namespace App\Pages\Backend\Report;

use App\Http\Common\Component;

class GenerationIncomeReport extends Component
{
    public function render()
    {
        return view('pages.backend.report.generation-income-report');
    }
}
