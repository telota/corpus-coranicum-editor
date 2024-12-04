<?php

namespace App\Models\Manuscripts;

use App\Models\Manuscripts\ManuscriptPageMapping;
use Illuminate\Database\Eloquent\Model;

class ManuscriptMapping extends Model
{
    protected $table = "ms_manuscript_mapping";

    protected $guarded = [
        "id"
    ];

    protected $fillable =  [
        "manuscript_id",
        "sura_start", "verse_start", "word_start",
        "sura_end", "verse_end", "word_end"
    ];

    public $timestamps = true;

}
