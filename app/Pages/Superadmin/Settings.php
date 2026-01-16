<?php

namespace App\Pages\Superadmin;

use App\Models\Setting;
use Livewire\WithFileUploads;
use App\Http\Common\Component;
use Illuminate\Support\Facades\Auth;

class Settings extends Component
{
    use WithFileUploads;
    public $parameter = [];

    public function parameterStore()
    {
        foreach($this->parameter as $key => $value) {
            Setting::where('parameter', $key)->updateOrCreate(
                ['parameter' => $key],
                ['value' => $value]
            );
        }

        $this->alert('success', 'Setting updated successfully');
    }
    public function mount()
    {
        $Setting = Setting::query();

        $Setting->get()->map(function ($item) {
            $this->parameter[$item->parameter] = $item->value;
        });
    }
    public function render()
    {
        return view('pages.superadmin.settings', [
            'User' => Auth::user()
        ]);
    }
}
