<?php

namespace App\Pages\Backend\Components;

use App\Http\Common\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public function logout()
    {
        Auth::guard('web')->logout();

        session()->invalidate();

        session()->regenerateToken();

        return redirect()->route('frontend.home');
    }

    public function render()
    {
        return view('pages.backend.components.logout');
    }
}
