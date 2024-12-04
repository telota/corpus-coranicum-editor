<?php

namespace App\Models\Intertexts;

use App\Models\GeneralCC\TranslationLanguage;
use Illuminate\Database\Eloquent\Model;


class IntertextOriginalTranslation extends Model
{
    protected $table = "it_intertext_source_text_original_translations";

    protected $fillable = ["intertext_id", "language_id", "source_text_translation_reference", "source_text_translation"];

    protected $guarded = ["id"];

    public $timestamps = true;

    public $editAlter = array(
        "language_id",
        "intertext_id",
        "translator_id"
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
        "source_text_translation",
        "source_text_translation_reference"
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
        return $this->hasOne(Intertext::class, "id", "intertext_id");
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
