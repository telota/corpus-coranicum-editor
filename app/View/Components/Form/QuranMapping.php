<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class QuranMapping extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $m,
        public bool $withWord,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.quran-mapping');
    }
}
