<?php

namespace App\Pages\Backend\Components;

use App\Http\Common\Component;
use App\Models\MemberTree;

class MemberView extends Component
{
    public $memberTree;

    protected $listeners = [
        'openMemberViewModal',
    ];

    public function openMemberViewModal($data = [])
    {
        if (isset($data['id'])) {
            $this->memberTree = MemberTree::find($data['id']);
            if ($this->memberTree) {
                $this->dispatch('modalOpen', 'MemberViewModal');
            }
        }
    }

    public function render()
    {
        return view('pages.backend.components.member-view');
    }
}
