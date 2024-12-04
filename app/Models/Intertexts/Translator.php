<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;

class Translator extends Model
{
    protected $table = "it_translators";

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
                "created_at"
            );


    public function intertexts()
    {
        return $this->hasMany(IntertextAuthor::class, 'author_id');
    }

}
