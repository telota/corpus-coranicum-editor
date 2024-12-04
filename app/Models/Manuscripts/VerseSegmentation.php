<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;

class VerseSegmentation extends Model
{
    use CreatedUpdatedBy;
    protected $table = "ms_verse_segmentations";

}
