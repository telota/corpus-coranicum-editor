<?php

namespace App\View\Components\Form;

use App\Enums\FormAction;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class DatalistInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string     $label,
        public FormAction $action,
        public Collection $options,
        public ?string    $value,
        public string     $name,
        public string     $id,
        public bool       $show = true,
        public bool       $create = true,
        public bool       $edit = true,

    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.datalist-input');
    }
}