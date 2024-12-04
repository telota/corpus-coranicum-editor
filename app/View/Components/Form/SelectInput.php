<?php

namespace App\View\Components\Form;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class SelectInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string     $label,
        public string     $name,
        public Collection      $options,
        public ?string     $value,
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
        return view('components.form.select-input');
    }
}
