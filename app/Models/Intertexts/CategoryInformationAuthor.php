<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;


class CategoryInformationAuthor extends Model
{
    protected $table = "it_category_information_authors";

    protected $guarded = ["id"];

    public $timestamps = true;


    /**
     * Get associated author
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function author()
    {
        return $this->hasOne(\App\Models\GeneralCC\CCAuthor::class, "id", "info_author_id");
    }

    /**
     * Get associated manuscript
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function category()
    {
        return $this->hasOne(IntertextCategory::class, "id", "category_id");
    }

}
