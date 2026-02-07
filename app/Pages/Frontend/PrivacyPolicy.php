<?php
namespace App\Pages\Frontend;

use App\Http\Common\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.frontend')]
class PrivacyPolicy extends Component
{
    public function render()
    {
        return view('pages.frontend.privacy-policy');
    }
}
