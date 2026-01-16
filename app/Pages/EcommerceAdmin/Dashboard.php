<?php

namespace App\Pages\EcommerceAdmin;

use App\Http\Common\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('pages.ecommerce-admin.dashboard');
    }
}
