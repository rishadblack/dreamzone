<?php
namespace App\Pages\Frontend;

use App\Http\Common\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.frontend')]
class CompanyProfile extends Component
{
    public function render()
    {
        return view('pages.frontend.company-profile');
    }
}
