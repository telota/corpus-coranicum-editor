<?php

namespace App\View\Components;

use App\Enums\Category;
use App\Enums\FormAction;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Entity extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public FormAction $action,
        public            $entity,
        public string $component,
        public string $formUrl,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.entity');
    }
}
