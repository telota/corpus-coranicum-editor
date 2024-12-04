<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;


class IntertextMapping extends Model
{
    protected $table = "it_intertext_mapping";

    public $timestamps = true;

    protected $fillable = ['id'];


    /**
     * Get readable text coordinate.
     * TODO: Use trait
     * @return string
     */
    public function readableTextstelle()
    {
        if ($this->sure_start == $this->sure_end && $this->vers_start == $this->vers_end) {
            return str_pad($this->sure_start, 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($this->vers_start, 3, 0, STR_PAD_LEFT);
        } else {
            return str_pad($this->sure_start, 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($this->vers_start, 3, 0, STR_PAD_LEFT) . "-" .
                str_pad($this->sure_end, 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($this->vers_end, 3, 0, STR_PAD_LEFT);
        }
    }
}
