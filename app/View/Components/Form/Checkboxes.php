<?php

namespace App\View\Components\Form;

use App\Enums\FormAction;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Checkboxes extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string     $label,
        public string     $name,
        public FormAction $action,
        public Collection $options,
        public Collection $values,
        public string     $displayText = '',
        public bool       $show = true,
        public bool       $create = true,
        public bool       $edit = true,

    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.checkboxes');
    }
}
