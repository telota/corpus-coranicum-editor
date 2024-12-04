<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManuscriptDiacritic extends Pivot
{
    use CreatedUpdatedBy;

    protected $table = "ms_manuscript_diacritics";

    protected $guarded = ["id"];

    public $timestamps = true;

}
