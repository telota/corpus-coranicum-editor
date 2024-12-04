<?php

namespace App\View\Components\Form;

use App\Enums\FormAction;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Authors extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $entity,
        public FormAction $action,
        public string $role,
        public string $module,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.authors');
    }
}
