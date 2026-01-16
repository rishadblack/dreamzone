<?php

namespace App\Pages\Superadmin;

use App\Models\Package;
use App\Http\Common\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PackageList extends Component
{
    use LivewireAlert;

    public $package_id;
    public $name;
    public $details;
    public $flash_condition;
    public $point_value;
    public $amount;
    public $type;
    public $is_default;
    public $status;


    #[On('openPackageModal')]
    public function openPackageModal($data = null)
    {
        $this->reset();

        if (isset($data['id'])) {
            $this->editPackage($data['id']);
        }

        $this->dispatch('modalOpen', 'PackageModal');
    }

    public function editPackage($id)
    {
        $Package = Package::find($id);
        $this->package_id = $Package->id;
        $this->name = $Package->name;
        $this->details = $Package->details;
        $this->flash_condition = $Package->flash_condition;
        $this->point_value = $Package->point_value;
        $this->amount = $Package->amount;
        $this->type = $Package->type;
        $this->is_default = $Package->is_default ? true : null;
        $this->status = $Package->status;

        // $this->updatedUsername($Package->User->username);
    }

    public function storePackage()
    {
        $this->validate([
            'name' => ['required'],
        ]);

        $Package = Package::findOrNew($this->package_id);
        $Package->user_id = Auth::id();
        $Package->name = $this->name;
        $Package->details = $this->details;
        $Package->flash_condition = $this->flash_condition;
        $Package->point_value = $this->point_value;
        $Package->amount = $this->amount;
        $Package->type = $this->type;
        $Package->status = $this->status;
        $Package->save();

        $this->dispatch('modalClose', 'PackageModal');
        $this->alert('success', 'Package updated successfully');
        $this->dispatch('refreshdatatable');

        $this->reset();
    }

    public function render()
    {
        return view('pages.superadmin.package-list');
    }
}
