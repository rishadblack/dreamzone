<?php

namespace App\View\Components\Search;

use App\Models\User;
use Illuminate\View\Component;

class TeamSearch extends Component
{
    public $dealerType;

    public function __construct($dealerType = null)
    {
        $this->dealerType = $dealerType;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $users = User::whereNotNUll('team_type');

        if ($this->dealerType) {
            $users->whereTeamType($this->dealerType);
        }

        return view('components.search.team-search', [
            'users' => $users->get(),
        ]);
    }
}
