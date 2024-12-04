<?php

namespace App\Models\Intertexts;

use App\Models\GeneralCC\TranslationLanguage;
use Illuminate\Database\Eloquent\Model;


class IntertextEntryTranslation extends Model
{
    protected $table = "it_intertext_entry_translations";

//    protected $fillable = ["language_id", "translator_id", "entry"];

    protected $guarded = ["id"];

    public $timestamps = true;

    public $editAlter = array(
        "language_id",
        "translator_id",
        "intertext_id"
    );

    public $editIgnore = array(
        "id",
        "created_at",
        "updated_at",
        "updated_by",
        "created_by",
        "intertext",
        "language"
    );

    public $editLarge = array(
        "entry_translation"
    );

    /**
     * Get associated author
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function language()
    {
        return $this->hasOne(TranslationLanguage::class, "id", "language_id");
    }

    /**
     * Get associated manuscript
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function intertext()
    {
        return $this->belongsTo(Intertext::class, "intertext_id");
    }

    /**
     * Get associated manuscript
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translator()
    {
        return $this->hasOne(\App\Models\GeneralCC\CCAuthor::class, "id", "translator_id");
    }
}
