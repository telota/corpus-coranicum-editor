<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManuscriptVerseSegmentation extends Pivot
{
    use CreatedUpdatedBy;

    protected $table = "ms_manuscript_verse_segmentations";

    protected $guarded = ["id"];

    public $timestamps = true;

}
