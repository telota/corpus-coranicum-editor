<?php

namespace App\Models\Manuscripts;

use App\Models\Manuskripte\BelongsToManuskriptTrait;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManuscriptScriptStyle extends Pivot
{
    use CreatedUpdatedBy;

    protected $table = "ms_manuscript_script_styles";

    protected $guarded = ["id"];

    public $timestamps = true;

}
