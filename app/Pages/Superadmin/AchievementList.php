<?php

namespace App\Pages\Superadmin;

use App\Http\Common\Component;
use App\Models\Achievement;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AchievementList extends Component
{
    use LivewireAlert;
    public $date_filter;
    public $filter_incentives;
    public $filter_type;

    #[On('changeReceiveStatus')]
    public function changeReceiveStatus($data = [])
    {
        if (isset($data['id'])) {
            $Achievement = Achievement::find($data['id']);
            $Achievement->is_received = now();
            $Achievement->save();

            $this->alert('success', 'Receive status changed successfully.');
            $this->dispatch('refreshDatatable');
        }
    }

    public function render()
    {
        return view('pages.superadmin.achievement-list');
    }
}
