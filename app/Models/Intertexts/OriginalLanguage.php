<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;

class OriginalLanguage extends Model
{
    protected $table = "it_original_languages";

    protected $guarded = [
        "id"
    ];

    public $timestamps = true;

    /**
     * Attributes that should not be shown in the editing view
     *
     * @return array
     */
    public $editIgnore =
            array(
                "id",
                "updated_at",
                "created_at",
                "updated_by",
                "created_by"
            );


    public function intertexts()
    {
        return $this->hasMany(Intertext::class, 'language_id');
    }

}
