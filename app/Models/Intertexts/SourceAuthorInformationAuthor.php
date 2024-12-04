<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;


class SourceAuthorInformationAuthor extends Model
{
    protected $table = "it_source_author_information_authors";

    protected $guarded = ["id"];

    public $timestamps = true;


    /**
     * Get associated author
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function infoAuthor()
    {
        return $this->hasOne(\App\Models\GeneralCC\CCAuthor::class, "id", "info_author_id");
    }

    /**
     * Get associated manuscript
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function author()
    {
        return $this->hasOne(SourceAuthor::class, "id", "author_id");
    }

}
