<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;


class IntertextTextEditing extends Model
{
    protected $table = "it_intertext_text_editing";

    protected $fillable = ["intertext_id", "author_id"];

    protected $guarded = ["id"];

    public $timestamps = true;


    /**
     * Get associated author
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function author()
    {
        return $this->hasOne(\App\Models\GeneralCC\CCAuthor::class, "id", "author_id");
    }

    /**
     * Get associated manuscript
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function intertext()
    {
        return $this->hasOne(Intertext::class, "id", "intertext_id");
    }
}
