<?php

namespace App\View\Components;

use App\Models\Selections;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideBar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->data = Selections::all();
    }

    public function render(): View|Closure|string
    {
        return view('components.side-bar');
    }
}
