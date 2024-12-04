<?php

namespace App\View\Components\Form;

use App\Enums\FormAction;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Number extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string     $label,
        public FormAction $action,
        public      $entity,
        public ?string    $dbField = null,
        public bool       $show = true,
        public bool       $create = true,
        public bool       $edit = true,
    )
    {
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.number');
    }
}
