<?php

namespace App\Models\Intertexts;

use App\Models\Manuscripts\ManuscriptAuthor;
use App\Models\Sure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;


class Intertext extends Model
{
    protected $table = "it_intertext";

    protected $primaryKey = "id";

    protected $guarded = [
        "id"
    ];

     public $timestamps = false;

    public $editIgnore = array(
        "id",
        "created_at",
        "updated_at",
        "last_author",
        "source_text_original",
        "language_direction",
        "intertext_date_end",
        "wort_s",
        "wort_e",
        "quran_texts",
        "published_at",
        "created_by",
        "updated_by"
    );

    public $editLarge = array(
        "entry",
        "source_text_edition",
        "source_text_transcription",
        "explanation_about_edition",
        "reference_translation_source_text"
    );

    public $editAlter = array(
        "quran_text",
        "images",
        "language_id",
        "category_id",
        "intertext_date_start",
        "script_id",
        "date_of_entry",
        "source_id",
        "info_author_id",
        "tuk_reference"
    );

    public $editAdmin = array(
        "is_online"
    );

    /**
     * Set text coordinate
     * @param $textstelle
     */
    public function setTextstelleKoranAttribute($textstelle)
    {
        $this->attributes["quran_text"] = $textstelle;
    }

    /**
     * Get text coordinates for this TUK
     * @return mixed
     */
    public function quranTexts()
    {
        return $this->hasMany(IntertextMapping::class, 'intertext_id', 'id')
            ->orderBy("sure_start", "ASC")
            ->orderBy("vers_start", "ASC");
    }

    /**
     * Get images belonging to this TUK
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(IntertextIllustration::class, 'intertext_id', 'id');
    }

    /**
     * Get topic category
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function themenKategorie()
    {
        return $this->hasOne(IntertextCategory::class, 'id', 'category_id');
    }

    /**
     * Get full name of category
     * @return string
     */
    public function getFullCategoryNameAttribute()
    {
        if ($this->themenKategorie->category_name) {
            if (IntertextCategory::where("id", $this->category_id)->count()) {
                return "{$this->category_id}: {$this->themenKategorie->category_name}";
            } else {
                Session::flash("flash_type", "alert-danger");
                Session::flash("flash_message", "Kategorie {$this->category_id} ist ungültig / existiert nicht");
                return "{$this->category_id}: --- Kategorie ist ungültig / existiert nicht ---.";
            }
        }

        return null;
    }

//    /**
//     * Get a collection of people who othered this record
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function editors()
//    {
//        return $this->hasMany(IntertextAuthor::class, "id", "belegstelle"); //TODO
//    }

    /**
     * Put the text coordinates into the default timeline
     * @return array
     */
    public function koranstellenChronology()
    {
        $sure = new Sure();

        $koranstellen = $this->quranTexts;

        $chronologyArray = array();
        $chronologyArray["I"] = array();
        $chronologyArray["II"] = array();
        $chronologyArray["III"] = array();
        $chronologyArray["IV"] = array();
        $chronologyArray["None"] = array();
        $chronologyArray["None"][0] = array();

        // Populate with chronology
        foreach ($sure->mekkaI as $ms) {
            $chronologyArray["I"][$ms] = array();
        }

        // Populate with chronology
        foreach ($sure->mekkaII as $ms) {
            $chronologyArray["II"][$ms] = array();
        }

        // Populate with chronology
        foreach ($sure->mekkaIII as $ms) {
            $chronologyArray["III"][$ms] = array();
        }

        // Populate with chronology
        foreach ($sure->medinaSuren as $ms) {
            $chronologyArray["IV"][$ms] = array();
        }

        foreach ($koranstellen as $koranstelle) {
            $chrono = $sure->getChronology($koranstelle->sure_start);

            if ($chrono == false) {
                array_push($chronologyArray["None"][0], $koranstelle);
            } else {
                array_push($chronologyArray[$chrono][$koranstelle->sure_start], $koranstelle);
            }
        }

        return $chronologyArray;
    }

    /**
     * Put the text coordinates into the default timeline, and display them as a human readable string
     * @return array
     */
    public function koranstellenChronologyString()
    {
        $koranstellenChrono = $this->koranstellenChronology();

        $chronologyStrings = array();

        foreach ($koranstellenChrono as $chrono => $chronoSuren) {
            $chronoString = "";

            foreach ($chronoSuren as $chronoSuren => $koranstellen) {
                foreach ($koranstellen as $koranstelle) {
                    $chronoString .= $koranstelle->readableTextstelle();

                    $chronoString .= ", ";
                }
            }

            $chronologyStrings[$chrono] = rtrim($chronoString, ", ");
        }

        return $chronologyStrings;
    }

    /**
     * Get all available languages found in TUKs
     * @return \Illuminate\Support\Collection
     */
    public static function getAllLanguages()
    {
        $allLanguages = collect(OriginalLanguage::all()->pluck("original_language"))->unique()->sort()->values()->toArray();
        array_unshift($allLanguages, "None");

        return collect(array_combine($allLanguages, $allLanguages));
    }


    /**
     * Get all available script languages found in TUKs
     * @return \Illuminate\Support\Collection
     */
    public static function getAllScripts()
    {
        $scriptArray = collect(Script::all()->pluck("script"))->unique()->sort()->values()->toArray();
        array_unshift($scriptArray, "None");

        return collect(array_combine($scriptArray, $scriptArray));
    }

    /**
     * Get a collection of people who othered this record
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function originalTranslations()
    {
        return $this->hasMany(IntertextOriginalTranslation::class, "intertext_id", "id");
    }

    /**
     * Get a collection of people who othered this record
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entryTranslations()
    {
        return $this->hasMany(IntertextEntryTranslation::class, "intertext_id", "id");
    }

    /**
     * Get all available script languages found in TUKs
     * @param bool $pretty
     * @return \Illuminate\Support\Collection
     */
    public static function getAllTranslationLanguages($pretty = true) //TODO
    {

        $languages = TranslationLanguage::all();
        $languageArray = array();

        for ($i = 0; $i < sizeof($languages); $i++) {
            $lang = urldecode(preg_split("/[\\/( ;]/", $languages[$i]->translation_language)[0]);
            if (!in_array($lang, $languageArray)) {
                array_push($languageArray, $lang);
            }
        }

        if ($pretty) {
            return collect(array_combine($languageArray, $languageArray));
        }

        return collect($languageArray);

    }

    /**
     * The default timelines
     * @return array
     */
    public function chronology() //TODO
    {
        $chronoArray = array();
        $chronoArray["I"] = 0;
        $chronoArray["II"] = 0;
        $chronoArray["III"] = 0;
        $chronoArray["IV"] = 0;

        $suren = new Sure();

        foreach ($this->quranTexts as $quranText) {
            for ($sure = $quranText->sure_start; $sure <= $quranText->sure_end; $sure++) {
                $chronology = $suren->getChronology($sure);

                if (in_array($chronology, array("I", "II", "III", "IV"))) {
                    $chronoArray[$chronology] += 1;
                }

                //array_push($chronoArray, $suren->getChronology($sure));
            }
        }

        //$chronoArray = array_unique($chronoArray);

        //sort($chronoArray);

        return $chronoArray;
    }

    /**
     * Get associated authors
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function originalLanguage()
    {
        return $this->hasOne(OriginalLanguage::class, "id", "language_id");
    }

    /**
     * Get associated authors
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scriptLanguage()
    {
        return $this->hasOne(Script::class, "id", "script_id");
    }

    /**
     * Get associated authors
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function source()
    {
        return $this->hasOne(IntertextSource::class, "id", "source_id");
    }


    /**
     * Get associated authors
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authors()
    {
        return $this->hasMany(IntertextAuthor::class, "intertext_id", "id");
    }

    /**
     * Get associated collaborators
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collaborators()
    {
        return $this->hasMany(IntertextCollaborator::class, "intertext_id", "id");
    }


    /**
     * Get associated updaters
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function updaters()
    {
        return $this->hasMany(IntertextUpdater::class, "intertext_id", "id");
    }


    /**
     * Get associated text editing
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function textEditing()
    {
        return $this->hasMany(IntertextTextEditing::class, "intertext_id", "id");
    }


    /**
     * Get available authors
     * @return array
     */
    public function getAuthors()
    {
        $authors = $this->authors;
        $authorArray = array_map(function($author) {return $author->author->author_name;}, $authors->all());
        return $authorArray;
    }


    /**
     * Get available collaborators
     * @return array
     */
    public function getCollaborators()
    {
        $authors = $this->collaborators;
        $authorArray = array_map(function($author) {return $author->author->author_name;}, $authors->all());
        return $authorArray;
    }

    /**
     * Get available updaters
     * @return array
     */
    public function getUpdaters()
    {
        $authors = $this->updaters;
        $authorArray = array_map(function($author) {return $author->author->author_name;}, $authors->all());
        return $authorArray;
    }


    /**
     * Get available text editing
     * @return array
     */
    public function getTextEditing()
    {
        $authors = $this->textEditing;
        $authorArray = array_map(function($author) {return $author->author->author_name;}, $authors->all());
        return $authorArray;
    }


    /**
     * Get available authors
     * @return array
     */
    public function getNameString()
    {
//        dd($this->source);
        if($this->source == null) return 'to be updated';

        $authorId = $this->source->author_id;
        $author = SourceAuthor::find($authorId)->author_name;
        if ($author == "Anonymous" | $author == "anonymous") $author = "";
        else $author = $author . ", ";
        $source = $this->source->source_name;
        $name = $author . $source ;
        if ($this->source_chapter)
            $name = $name . ": " . $this->source_chapter;
        return $name;
    }
}
