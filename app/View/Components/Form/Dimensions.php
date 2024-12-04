<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Dimensions extends Component
{

    public $width;
    public $height;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        ?string $dimensionString,
        public string $title,
        public string $labelWidth,
        public string $labelHeight,
        public string $nameWidth,
        public string $nameHeight,

    )
    {
        if(isset($dimensionString)){
            $wh = explode(" x ",$dimensionString);
            if(sizeof($wh)==2){
                $this->width = $wh[0];
                $this->height = $wh[1];

            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.dimensions');
    }
}
