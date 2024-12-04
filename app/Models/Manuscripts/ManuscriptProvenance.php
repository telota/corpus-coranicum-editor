<?php

namespace App\Models\Manuscripts;

use App\Models\Manuskripte\BelongsToManuskriptTrait;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManuscriptProvenance extends Pivot
{
    use CreatedUpdatedBy;

    protected $table = "ms_manuscript_provenances";

    protected $guarded = ["id"];

    public $timestamps = true;

}
