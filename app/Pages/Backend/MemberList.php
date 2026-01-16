<?php
namespace App\Pages\Backend;

use App\Models\MemberTree;
use App\Models\User;
use App\Traits\UsernameSearchTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MemberList extends Component
{
    use UsernameSearchTrait;

    public $teamMember;
    public $teamAMember;
    public $teamBMember;
    public $teamAMemberA;
    public $teamAMemberB;
    public $teamBMemberA;
    public $teamBMemberB;
    public $username;

    protected $listeners = [
        'getTeam',
    ];

    public function updatedUsername($value)
    {
        $this->resetErrorBag();

        $user = User::where('username', $value)->first();
        if ($user) {
            $this->getTeam(['data' => $user->id]);
        } else {
            $this->addError('username', 'Search member account is not found');
        }
    }

    public function getTeam($data = [])
    {
        if (isset($data['id'])) {
            $id = $data['id'];
        } else {
            $id = Auth::id();
        }

        if (DB::table('member_trees')->whereUserId(Auth::id())->wherePlacementId($id)->exists()) {
            $id = Auth::id();
        } else {
            if ($this->checkUp($id)) {
                $id = $id;
            } else {
                $id = Auth::id();
            }
        }

        $this->teamMember = MemberTree::where('user_id', $id)->first();

        if ($this->teamMember) {
            $this->teamAMember = MemberTree::where('user_id', $this->teamMember->l_id)->first();
            $this->teamBMember = MemberTree::where('user_id', $this->teamMember->r_id)->first();
        } else {
            $this->teamAMember = null;
            $this->teamBMember = null;
        }

        if ($this->teamAMember) {
            $this->teamAMemberA = MemberTree::where('user_id', $this->teamAMember->l_id)->first();
            $this->teamAMemberB = MemberTree::where('user_id', $this->teamAMember->r_id)->first();
        } else {
            $this->teamAMemberA = null;
            $this->teamAMemberB = null;
        }

        if ($this->teamBMember) {
            $this->teamBMemberA = MemberTree::where('user_id', $this->teamBMember->l_id)->first();
            $this->teamBMemberB = MemberTree::where('user_id', $this->teamBMember->r_id)->first();
        } else {
            $this->teamBMemberA = null;
            $this->teamBMemberB = null;
        }
    }

    public function checkUp($id)
    {
        if ($id == Auth::id()) {
            return false;
        }

        $userId = DB::table('member_trees')->where('user_id', $id)->first('placement_id');

        if ($userId->placement_id && $userId->placement_id == Auth::id()) {
            return true;
        }

        if ($userId->placement_id) {
            return $this->checkUp($userId->placement_id);
        }

        return false;
    }

    public function mount()
    {
        $this->getTeam();
    }

    public function render()
    {
        return view('pages.backend.member-list');
    }
}
