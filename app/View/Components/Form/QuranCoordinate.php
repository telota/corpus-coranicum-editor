<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class QuranCoordinate extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $limit,
        public string $sura,
        public string $verse,
        public ?string $word,
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
        return view('components.form.quran-coordinate');
    }
}
