<?php

namespace App\View\Components;

use App\Enums\Category;
use App\Enums\FormAction;
use Illuminate\View\Component;

class CategoryEntity extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public FormAction $action,
        public            $entity,
        public Category   $category,
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
        return view('components.category-entity');
    }
}
