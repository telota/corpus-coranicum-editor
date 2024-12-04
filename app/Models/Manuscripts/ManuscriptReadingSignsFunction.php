<?php

namespace App\Models\Manuscripts;

use App\Models\Manuskripte\BelongsToManuskriptTrait;
use Illuminate\Database\Eloquent\Model;

class ManuscriptReadingSignsFunction extends Model
{
    use BelongsToManuskriptTrait;

    protected $table = "ms_manuscript_reading_signs_functions";

    protected $guarded = ["id"];

    public $timestamps = true;

}
