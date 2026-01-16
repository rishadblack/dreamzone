<?php

namespace App\Pages\Backend\Report;

use App\Http\Common\Component;

class SponsorReport extends Component
{
    public function render()
    {
        return view('pages.backend.report.sponsor-report');
    }
}
