<?php
namespace App\Pages\Frontend\Component;

use Illuminate\Support\Facades\Route;
use Livewire\Component;

class SearchComponent extends Component
{
    public $search;
    public $route_name;
    protected $queryString = ['search'];

    public function updatedSearch($value)
    {
        if ($this->route_name !== 'frontend.shop') {
            $this->redirect(route('frontend.shop', ['search' => $value]));
        }

        $this->dispatch('refreshSearch', $value);
    }

    public function mount()
    {
        $this->route_name = Route::currentRouteName();
    }

    public function render()
    {
        return view('pages.frontend.component.search-component');
    }
}
