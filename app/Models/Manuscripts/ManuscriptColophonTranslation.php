<?php

namespace App\Models\Manuscripts;

use App\Models\GeneralCC\TranslationLanguage;
use Illuminate\Database\Eloquent\Model;


class ManuscriptColophonTranslation extends Model
{
    protected $table = "ms_manuscript_colophon_text_translations";

//    protected $fillable = ["language_id", "translator_id", "entry"];

    protected $guarded = ["id"];

    public $timestamps = true;

    public $editAlter = array(
        "language_id",
        "translator_id",
        "manuscript_id"
    );

    public $editIgnore = array(
        "id",
        "created_at",
        "updated_at",
        "updated_by",
        "created_by",
        "manuscript",
        "language"
    );

    public $editLarge = array(
        "colophon_text_translation",
        "colophon_text_translation_reference"
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
    public function manuscript()
    {
        return $this->belongsTo(ManuscriptNew::class, "manuscript_id");
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
