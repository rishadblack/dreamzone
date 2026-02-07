<?php
namespace App\View\Components\Search;

use App\Models\Dealer;
use Illuminate\View\Component;

class DealerSearch extends Component
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
        $dealers = Dealer::active();

        if ($this->dealerType) {
            $dealers = $dealers->whereType(2);
        }

        return view('components.search.dealer-search', [
            'dealers' => $dealers->get(),
        ]);
    }
}