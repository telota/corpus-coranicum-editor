<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddButton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $id,
        public string $text,
        public ?string $title = "",
        public ?string $link = null,

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
        return view('components.add-button');
    }
}
