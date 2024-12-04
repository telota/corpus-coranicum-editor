<?php

namespace App\Models\Intertexts;

use App\Models\GeneralCC\TranslationLanguage;
use Illuminate\Database\Eloquent\Model;


class SourceInformationTranslation extends Model
{
    protected $table = "it_source_information_translations";

    protected $fillable = ["intertext_id", "language_id", "information_translation", "information_translation_reference"];

    protected $guarded = ["id"];

    public $timestamps = true;

    public $editAlter = array(
        "language_id",
        "translator_id",
        "source_id"
    );

    public $editIgnore = array(
        "id",
        "created_at",
        "updated_at",
        "updated_by",
        "created_by",
        "source",
        "language"
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
    public function source()
    {
        return $this->belongsTo(IntertextSource::class, "source_id");
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
