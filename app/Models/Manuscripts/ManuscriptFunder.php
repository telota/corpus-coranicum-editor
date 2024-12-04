<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManuscriptFunder extends Pivot
{
    protected $table = "ms_manuscript_funders";
    use CreatedUpdatedBy;
    protected $guarded = ["id"];

    public $timestamps = true;
}
