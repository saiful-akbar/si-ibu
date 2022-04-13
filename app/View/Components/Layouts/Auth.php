<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Auth extends Component
{
    public $title;
    public $backButton;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $backButton = null)
    {
        $this->title      = $title;
        $this->backButton = $backButton;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layouts.auth');
    }
}
