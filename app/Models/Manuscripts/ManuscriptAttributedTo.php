<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManuscriptAttributedTo extends Pivot
{
    use CreatedUpdatedBy;

    protected $table = "ms_manuscript_attributed_to";

    protected $guarded = ["id"];

    public $timestamps = true;

}
