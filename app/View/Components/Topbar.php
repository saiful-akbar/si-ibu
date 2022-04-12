<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Topbar extends Component
{
    public $profil;
    public $divisi;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->profil = auth()->user()->profil;
        $this->divisi = auth()->user()->divisi;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.topbar');
    }
}
