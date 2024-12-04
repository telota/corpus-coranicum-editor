<?php

namespace App\View\Components;

use App\Enums\Category;
use Illuminate\View\Component;

class IndexRow extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public Category $category,
        public $entity,
    ) { }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.index-row');
    }
}
