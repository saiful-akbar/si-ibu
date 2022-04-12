<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public $menu;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menu = auth()->user()->load([
            'menuHeader' => fn ($query) => $query->orderBy('no_urut', 'asc'),
            'menuItem' => fn ($query) => $query->orderBy('nama_menu', 'asc'),
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar');
    }
}
