<?php

namespace App\Models\Umwelttexte;

use App\Models\Sure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

/**
 * App\Models\Umwelttexte\Belegstelle
 *
 * @property int $ID
 * @property string $Titel
 * @property string $Sprache
 * @property string|null $Sprache_richtung
 * @property string $Ort
 * @property string $Datierung
 * @property string $Edition
 * @property string $Uebersetzung
 * @property string $Identifikator
 * @property string $Textsorte
 * @property string $HinweiseaufEdition
 * @property string $SchlagwortPersonen
 * @property string $SchlagwortOrte
 * @property string $SchlagwortSonst
 * @property string $Stichwort
 * @property string $TextstelleKoran
 * @property string $Anmerkungen
 * @property string $Anmerkungen_en
 * @property string $Uebersetzer
 * @property string $Bearbeiter
 * @property string $Einstelldatum
 * @property string $Anderungsdatum
 * @property string $Originalsprache
 * @property string $Transkription
 * @property string $Uebersetzung_dt
 * @property string $Uebersetzung_en
 * @property string $Uebersetzung_fr
 * @property string $Uebersetzung_ar
 * @property string $Autor
 * @property string $allfields
 * @property string $webtauglich
 * @property string $Bibeltext
 * @property string $Vermittlungssprache
 * @property string $Literatur
 * @property string $kategorie
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $lastAuthor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Umwelttexte\BelegstellenBearbeiter[] $editors
 * @property-read string $full_category_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Umwelttexte\BelegstellenBilder[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Umwelttexte\BelegstellenMapping[] $koranstellen
 * @property-write mixed $textstelle_koran
 * @property-read \App\Models\Umwelttexte\BelegstellenKategorie $themenKategorie
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereAllfields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereAnderungsdatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereAnmerkungen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereAnmerkungenEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereAutor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereBearbeiter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereBibeltext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereDatierung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereEdition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereEinstelldatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereHinweiseaufEdition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereIdentifikator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereKategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereLastAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereLiteratur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereOriginalsprache($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereOrt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereSchlagwortOrte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereSchlagwortPersonen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereSchlagwortSonst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereSprache($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereSpracheRichtung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereStichwort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereTextsorte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereTextstelleKoran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereTitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereTranskription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereUebersetzer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereUebersetzung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereUebersetzungAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereUebersetzungDt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereUebersetzungEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereUebersetzungFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereVermittlungssprache($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Belegstelle whereWebtauglich($value)
 * @mixin \Eloquent
 */
class Belegstelle extends Model
{
    protected $table = "belegstellen";

    protected $primaryKey = "ID";

    protected $guarded = [
        "ID"
    ];

    // public $timestamps = false;

    public $editIgnore = array(
        "id",
        "created_at",
        "updated_at",
        "lastauthor",
        "originalsprache",
        "sprache_richtung"
    );

    public $editLarge = array(
        "anmerkungen",
        "anmerkungen_en",
        "edition",
        "uebersetzung_dt",
        "uebersetzung_en",
        "uebersetzung_fr",
        "uebersetzung_ar",
        "uebersetzer",
        "identifikator",
        "transkription",
        "literatur"
    );

    public $editAlter = array(
        "textstellekoran",
        "images",
        "sprache",
        "kategorie"
    );

    public $editAdmin = array(
        "webtauglich"
    );

    public static function forSummernote(){
        return self::select('id', 'titel')->where('titel', '!=', '')->orderby('id', 'asc')->get()
            ->map(function ($value) {
                return [
                    'id' => str_pad($value->id, 5, "0", STR_PAD_LEFT),
                    'titel' =>  html_entity_decode($value->titel),
                ];
            });

    }

    /**
     * Set text coordinate
     * @param $textstelle
     */
    public function setTextstelleKoranAttribute($textstelle)
    {
        $this->attributes["TextstelleKoran"] = $textstelle;
    }

    /**
     * Get text coordinates for this TUK
     * @return mixed
     */
    public function koranstellen()
    {
        return $this->hasMany(BelegstellenMapping::class, 'belegstelle', 'ID')
            ->orderBy("sure_start", "ASC")
            ->orderBy("vers_start", "ASC");

    }

    public static function makeEnglishLanguageMapping($p)
    {
        $p['sura_start'] = $p->sure_start;
        $p['sura_end'] = $p->sure_ende;
        $p['verse_start'] = $p->vers_start;
        $p['verse_end'] = $p->vers_ende;
        return $p;
    }

    /**
     * Get images belonging to this TUK
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(BelegstellenBilder::class, 'belegstelle', 'ID');
    }

    /**
     * Get topic category
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function themenKategorie()
    {
        return $this->hasOne(BelegstellenKategorie::class, 'id', 'kategorie');
    }

    public function mentionedInCommentary()
    {
        return $this->belongsToMany(Belegstelle::class,
            'kommentar_belegstelle',
            'belegstelle_id',
            'sure',
            'ID',
        );
    }

    /**
     * Get full name of category
     * @return string
     */
    public function getFullCategoryNameAttribute()
    {
        if ($this->kategorie) {
            if (BelegstellenKategorie::where("id", $this->kategorie)->count()) {
                return "{$this->kategorie}: {$this->themenKategorie->name}";
            } else {
                Session::flash("flash_type", "alert-danger");
                Session::flash("flash_message", "Kategorie {$this->kategorie} ist ungültig / existiert nicht");
                return "{$this->kategorie}: --- Kategorie ist ungültig / existiert nicht ---.";
            }
        }

        return null;
    }

    /**
     * Get a collection of people who othered this record
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function editors()
    {
        return $this->hasMany(BelegstellenBearbeiter::class, "id", "belegstelle");
    }

    /**
     * Put the text coordinates into the default timeline
     * @return array
     */
    public function koranstellenChronology()
    {
        $sure = new Sure();

        $koranstellen = $this->koranstellen;

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
     * @param bool $pretty
     * @return \Illuminate\Support\Collection
     */
    public static function getAllLanguages($pretty = true)
    {
        $languages = Belegstelle::select("Sprache")->groupBy("Sprache")->get()->pluck("Sprache");

        $languageArray = array();

        for ($i = 0; $i < sizeof($languages); $i++) {
            $lang = urldecode(preg_split("/[\\/( ;]/", $languages[$i])[0]);

            if (!in_array($lang, $languageArray)) {
                array_push($languageArray, $lang);
            }
        }

        if ($pretty) {
            return collect(array_combine($languageArray, $languageArray));
        }

        $rawLanguages = collect(Belegstelle::all()->pluck("Sprache"))->unique()->sort()->values();

        $allLanguages = collect($languageArray)->merge($rawLanguages)->unique()->sort();

        return collect(array_combine($allLanguages->toArray(), $allLanguages->toArray()));
    }

    /**
     * The default timelines
     * @return array
     */
    public function chronology()
    {
        $chronoArray = array();
        $chronoArray["I"] = 0;
        $chronoArray["II"] = 0;
        $chronoArray["III"] = 0;
        $chronoArray["IV"] = 0;

        $suren = new Sure();

        foreach ($this->koranstellen as $koranstelle) {
            for ($sure = $koranstelle->sure_start; $sure <= $koranstelle->sure_ende; $sure++) {
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
}
