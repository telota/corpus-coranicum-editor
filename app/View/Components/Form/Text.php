<?php

namespace App\View\Components\Form;

use App\Enums\FormAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Text extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string     $label,
        public FormAction $action,
        public      $entity,
        public ?string    $dbField = null,
        public ?string    $placeholder = null,
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
        return view('components.form.text');
    }
}
