<?php

namespace App\Models\GeneralCC;

use App\Models\Intertexts\CategoryInformationTranslation;
use App\Models\Intertexts\IntertextEntryTranslation;
use App\Models\Intertexts\IntertextOriginalTranslation;
use App\Models\Intertexts\SourceAuthorInformationTranslation;
use App\Models\Intertexts\SourceInformationTranslation;
use App\Models\Manuscripts\ManuscriptColophonTranslation;
use Illuminate\Database\Eloquent\Model;

class TranslationLanguage extends Model
{
    protected $table = "cc_translation_languages";

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
                "created_at",
                "updated_by",
                "created_by"
            );

//    INTERTEXT TRANSLATIONS

    public function intertextOriginalTranslations()
    {
        return $this->hasMany(IntertextOriginalTranslation::class, 'language_id');
    }

    public function intertextEntryTranslations()
    {
        return $this->hasMany(IntertextEntryTranslation::class, 'language_id');
    }

    public function sourceInformationTranslations()
    {
        return $this->hasMany(SourceInformationTranslation::class, 'language_id');
    }

    public function sourceAuthorInformationTranslations()
    {
        return $this->hasMany(SourceAuthorInformationTranslation::class, 'language_id');
    }

    public function categoryInformationTranslations()
    {
        return $this->hasMany(CategoryInformationTranslation::class, 'language_id');
    }


//    MANUSCRIPT TRANSLATIONS

    public function colophonTextTranslations()
    {
        return $this->hasMany(ManuscriptColophonTranslation::class, 'language_id');
    }


    /**
     * Get all available languages found in TUKs
     * @param bool $pretty
     * @return \Illuminate\Support\Collection
     */
    public static function getAllLanguages($pretty = true) //TODO
    {

        $languages = TranslationLanguage::all();
        $languageArray = array('keine');

        for ($i = 0; $i < sizeof($languages); $i++) {
            $lang = $languages[$i]->translation_language;
//            $lang = urldecode(preg_split("/[\\/( ;]/", $languages[$i]->original_language)[0]);
            if (!in_array($lang, $languageArray)) {
                array_push($languageArray, $lang);
            }
        }

        if ($pretty) {
            return collect(array_combine($languageArray, $languageArray));
        }

        return collect($languageArray);

    }

}
