<?php

namespace App\Models\Manuscripts;


use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManuscriptReadingSign extends Pivot
{

    use CreatedUpdatedBy;
    protected $table = "ms_manuscript_reading_signs";

    protected $guarded = ["id"];

    public $timestamps = true;
}
