<?php

namespace App\Pages\Superadmin;

use App\Http\Common\Component;

class BalanceList extends Component
{
    public function render()
    {
        return view('pages.superadmin.balance-list');
    }
}
