<?php

namespace App\View\Components\Form;

use App\Enums\FormAction;
use Carbon\Carbon;
use Illuminate\View\Component;

class DateTime extends Component
{

    public ?string $day = null;
    public ?string $time = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public FormAction $action,
        public string $label,
        public string $dbField,
        public ?string $datetime = null,
        public bool       $show = true,
        public bool       $create = true,
        public bool       $edit = true,

    )
    {
        if(isset($datetime)){
            $parsed = Carbon::parse($datetime);
            $this->day = $parsed->toDateString();
            $this->time = $parsed->toTimeString('minute');
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.date-time');
    }
}
