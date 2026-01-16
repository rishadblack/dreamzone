<?php

namespace App\Http\Common;

use Livewire\Component as BaseComponent;
use App\Traits\WithSweetAlert;

abstract class Component extends BaseComponent
{
    use WithSweetAlert;
}
