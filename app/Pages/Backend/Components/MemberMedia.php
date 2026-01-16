<?php

namespace App\Pages\Backend\Components;

use App\Http\Common\Component;

class MemberMedia extends Component
{
    public $member_tree;


    public function render()
    {
        return view('pages.backend.components.member-media');
    }
}
