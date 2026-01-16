<?php

namespace App\Pages\Superadmin;

use App\Http\Common\Component;

class WithdrawalList extends Component
{
    public function render()
    {
        return view('pages.superadmin.withdrawal-list');
    }
}
