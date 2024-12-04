<?php

namespace App\Models\Intertexts;

use App\Models\GeneralCC\TranslationLanguage;
use Illuminate\Database\Eloquent\Model;


class SourceAuthorInformationTranslation extends Model
{
    protected $table = "it_source_author_information_translations";

    protected $fillable = ["intertext_id", "language_id", "information_translation", "information_translation_reference"];

    protected $guarded = ["id"];

    public $timestamps = true;

    public $editAlter = array(
        "language_id",
        "translator_id",
        "source_author_id"
    );

    public $editIgnore = array(
        "id",
        "created_at",
        "updated_at",
        "updated_by",
        "created_by",
        "language",
        "source_author"
    );

    public $editLarge = array(
        "information_translation",
        "information_translation_reference"
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
    public function sourceAuthor()
    {
        return $this->hasOne(SourceAuthor::class, "id", "source_author_id");
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
