<?php

namespace App\Pages\Backend\Components;

use App\Models\Fund;
use App\Models\User;
use App\Http\Common\Component;
use App\Models\MemberTree;
use Illuminate\Support\Facades\Auth;

class MemberDetails extends Component
{
    public $id;
    public $teamMember;
    public $teamMemberA;
    public $teamMemberB;
    public $teamFund = [];
    public $user_id;
    public $load_component;
    public $check_load_component = [];

    public function getTeam($id = null)
    {
        $this->teamMember = MemberTree::where('user_id', $id)->first();
        $this->teamMemberA = MemberTree::where('user_id', $this->teamMember->l_id)->first();
        $this->teamMemberB = MemberTree::where('user_id', $this->teamMember->r_id)->first();
    }

    public function mount($id = null)
    {
        $this->getTeam($id);
    }

    public function next($openId = null)
    {
        if($openId && isset($this->check_load_component[$openId])) {
            if($this->check_load_component[$openId]) {
                $this->check_load_component[$openId] = false;
            } else {
                $this->check_load_component[$openId] = true;
            }
        } elseif($openId) {
            $this->check_load_component[$openId] = true;
        }
        $this->load_component = 'backend.components.member-details';
    }

    public function render()
    {
        return view('pages.backend.components.member-details');
    }
}
