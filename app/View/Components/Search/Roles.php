<?php

namespace App\View\Components\Search;

use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class Roles extends Component
{

    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('components.search.roles',[
            "roles" => Role::all()
        ]);
    }
}
