<?php
namespace App\Pages\Backend\Report;

use App\Http\Common\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class CommonIncomeReport extends Component
{
    public $incomeType;

    public function mount()
    {
        $name = Str::afterLast(Route::currentRouteName(), '.');

        $this->incomeType = (object) collect(config('mlm.income_list'))->firstWhere('name', $name);
    }

    public function render()
    {
        return view('pages.backend.report.common-income-report');
    }
}
