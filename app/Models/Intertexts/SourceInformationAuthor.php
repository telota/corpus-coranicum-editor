<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;


class SourceInformationAuthor extends Model
{
    protected $table = "it_source_information_authors";

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
    public function source()
    {
        return $this->hasOne(IntertextSource::class, "id", "source_id");
    }

}
