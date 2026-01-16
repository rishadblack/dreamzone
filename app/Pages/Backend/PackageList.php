<?php

namespace App\Pages\Backend;

use App\Models\Package;
use App\Http\Common\Component;

class PackageList extends Component
{
    public function mount()
    {
        // $this->dispatchBrowserEvent('refreshdatatable');
    }

    public function render()
    {
        return view('pages.backend.package-list', [
            'packages' => Package::active()->get()
        ]);
    }
}
