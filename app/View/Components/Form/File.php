<?php

namespace App\View\Components\Form;

use App\Enums\FormAction;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class File extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string     $label,
        public FormAction $action,
        public string    $name,
        public ?string $path,
        public ?string    $placeholder = null,
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
        return view('components.form.file');
    }
}
