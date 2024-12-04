<?php

namespace App\View\Components;

use App\Enums\FormAction;
use Illuminate\View\Component;

class History extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $entity,
        public FormAction $action,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.history');
    }
}
