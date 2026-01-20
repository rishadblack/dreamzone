<?php
namespace App\Pages\Superadmin;

use App\Http\Common\Component;
use App\Models\Point;
use App\Traits\UsernameSearchTrait;
use App\Traits\UserTrait;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PointList extends Component
{
    use UsernameSearchTrait;
    use UserTrait;
    use LivewireAlert;

    public $point_id;

    public $username;
    public $flow;
    public $value;
    public $status;
    public $note;

    protected $listeners = [
        'openPointModal',
    ];

    public function openPointModal($data = null)
    {
        $this->reset();
        if (isset($data['id'])) {
            $this->editPoint($data['id']);
        }

        $this->dispatch('modalOpen', 'PointModal');
    }

    public function editPoint($id)
    {
        $Point = Point::find($id);
        $this->username = $Point->User->username;
        $this->flow = $Point->flow;
        $this->status = $Point->status;
        $this->note = $Point->note;
        $this->value = $Point->value;
        $this->point_id = $Point->id;
        $this->updatedUsername($Point->User->username);
    }

    public function storePoint()
    {
        $this->validate([
            'username' => ['required', 'exists:users,username'],
            'value' => 'required|numeric|min:1',
            'flow' => 'required',
        ]);

        $Point = Point::findOrNew($this->point_id);
        $Point->user_id = $this->getIdByUsername($this->username);
        $Point->parent_id = Auth::id();
        $Point->value = $this->value;
        $Point->type = 6;
        $Point->flow = $this->flow;
        $Point->generated_by = Auth::id();
        $Point->is_generated = true;
        $Point->status = $this->status;
        $Point->note = $this->note;
        $Point->save();

        $this->dispatch('modalClose', 'PointModal');
        $this->alert('success', 'Point generated successfull for ' . $this->username_name);
        $this->dispatch('refreshDatatable');

        $this->reset();
    }

    public function render()
    {
        return view('pages.superadmin.point-list');
    }
}