<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManuscriptRWTProvenance extends Pivot
{
    use CreatedUpdatedBy;

    protected $table = "ms_manuscript_rwt_provenances";

    protected $guarded = ["id"];

    public $timestamps = true;

}
