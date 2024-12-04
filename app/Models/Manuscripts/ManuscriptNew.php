<?php

namespace App\Models\Manuscripts;

use App\Models\GeneralCC\CCAuthorRole;
use App\Models\Koranstelle;
use App\Models\Manuscripts\ManuscriptMapping;
use App\Models\Sure;
use App\Models\PersistentIdentifier;
use App\Traits\CreatedUpdatedBy;
use Carbon\Carbon;
use Chumper\Zipper\Zipper;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Database\Eloquent\Model;
use App\Models\Helpers\IiifManifest;
use App\Models\Helpers\IiifSequence;
use Storage;

class ManuscriptNew extends Model
{

    use CreatedUpdatedBy;

    protected $table = "ms_manuscript";

    protected $primaryKey = "id";

    protected $guarded = [
        "id"
    ];

    //    protected $dateFormat = 'Y-m-d';
    //
    //    protected $dates = [
    //        'start_date',
    //        'end_date'
    //    ];

    public $timestamps = true;


    /**
     * Attributes that should be edited in a big text editor
     *
     * @return array
     */
    public $editLarge =
        array(
            "paleography",
            "codicology",
            "ornaments",
            "commentary_internal",
            "catalogue_entry"
        );


    /**
     * Attributes that should not be shown in the editing view
     *
     * @return array
     */
    public $editIgnore =
        array(
            "id",
            "is_online",
            "no_images",
            "is_online_old",
            "transliteration",
            "date_start",
            "date_end",
            "created_at",
            "updated_at",
            "colophon_text",
            "colophon_date_start",
            "colophon_date_end",
            "palimpsest_text",
            "sajda_signs_text",
            "doi",
            "updated_by",
            "created_by"
        );

    /**
     * Attributes that need an alternate editing view
     *
     * @return array
     */
    public $editAlter =
        array(
            "place_id",
            "writing_surface",
            "provenance_id",
            "dimensions",
            "format_text_field",
            "number_of_folios",
            "carbon_dating",
            "number_of_lines",
            "colophon",
            "palimpsest",
            "sajda_signs"
        );


    /**
     * Attributes that need an alternate editing view
     *
     * @return array
     */
    public $editRadioButton =
        array();

    //    OPTIONS RADIO BUTTON

    private static $optionsCurrency = [
        "Dollar" => "$",
        "Euro" => "€",
        "Deutsche Mark (DM)" => "DM",
        "Reichsmark (RM)" => "ℛℳ",
        "Pound sterling" => "£",
        "Unknown Price" => "Unknown Price"
    ];


    //    OPTIONS CHECKBOX


    /**
     * Options of reading signs functions (controlled data)
     *
     * @return array
     */
    private static $optionsReadingSignsFunction = [
        "vowels" => "Vowels",
        "vowels_mode" => "Mode of the vowel (ʾimāla “vowel inflection”)",
        "glottal" => "Glottal stop",
        "sadda" => "Reduplication (šadda)",
        "idgam" => "Assimilation (ʾidġām)",
        "ismam" => "different realization of a vowel that is written in colour (ʾišmām)"
    ];

    /**
     * Get all Mansuskriptseiten of a manuscript
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function manuscriptPages()
    {
        return $this->hasMany(ManuscriptPage::class, 'manuscript_id', "id")
            ->orderBy("folio")
            ->orderByRaw("FIELD(page_side,'','r','v','bis','bis r', 'bis v','ter','ter r','ter v')");
    }

    public function images()
    {
            return $this->hasManyThrough(ManuscriptPageImage::class,
                ManuscriptPage::class,
                'manuscript_id',
                'manuscript_page_id'
            );
    }

    public function getManuskriptseitenInRangeFromFolio($folioStart)
    {

        return $this->manuscriptPages->filter(function ($seite) use ($folioStart) {
            return intval($seite->folio) >= $folioStart;
        });
    }

    public function getManuskriptseitenInRangeFromPage($folioStart, $seiteStart)
    {

        if ($seiteStart == "r") {
            return $this->getManuskriptseitenInRangeFromFolio($folioStart);
        } else if ($seiteStart == "v") {
            return $this->manuscriptPages->filter(function ($seite) use ($folioStart, $seiteStart) {
                return (
                    (intval($seite->folio) > $folioStart) ||
                    (intval($seite->folio) == $folioStart && $seite->page_side == "v")
                );
            });
        }

        return [];
    }

    public function getManuskriptseitenInRangeToFolio($folioEnde)
    {

        return $this->manuscriptPages->filter(function ($seite) use ($folioEnde) {
            return intval($seite->folio) <= $folioEnde;
        });
    }

    public function getManuskriptseitenInRangeToPage($folioEnde, $seiteEnde)
    {

        if ($seiteEnde == "r") {

            return $this->manuscriptPages->filter(function ($seite) use ($folioEnde, $seiteEnde) {
                return (
                    (intval($seite->folio) < $folioEnde) ||
                    (intval($seite->folio) == $folioEnde && $seite->page_side == "r")
                );
            });
        } else if ($seiteEnde == "v") {
            return $this->getManuskriptseitenInRangeToFolio($folioEnde);
        }
    }

    private static function protectAgainstIllegalPageQuery($folioStart, $seiteStart, $folioEnde, $seiteEnde)
    {

        if ($folioStart > $folioEnde && $folioStart && $folioEnde) {
            throw new QueryException("The ending boundaries are lower than the starting boundaries");
        }

        if (($folioStart == $folioEnde) && ($seiteStart == "v") && ($seiteEnde == "r") && $folioStart && $folioEnde && $seiteStart && $seiteEnde) {
            throw new QueryException("The folio is the same, but 'v' may not be the starting page if 'r' is the ending page (v.v.)");
        }

        if (!(in_array($seiteStart, ["r", "v"]) || in_array($seiteEnde, ["r", "v"]) ||
            starts_with($seiteStart, "bis") || starts_with($seiteStart, "ter") ||
            starts_with($seiteEnde, "bis") || starts_with($seiteEnde, "ter")
        )) {
            throw new QueryException("The page name must be 'r', 'v', or must include 'bis' or 'ter' for mass assignment. You have: start - " . $seiteStart . " / end - " . $seiteEnde);
        }
    }

    public function getManuskriptseitenInRange($folioStart = null, $seiteStart = null, $folioEnde = null, $seiteEnde = null)
    {

        // When no parameters are given, then return all manuscript pages
        if (($folioStart == null) && ($seiteStart == null) && ($folioEnde == null) && ($seiteEnde == null)) {
            return $this->manuscriptPages;
        }

        // Protect against illegal queries
        $this->protectAgainstIllegalPageQuery($folioStart, $seiteStart, $folioEnde, $seiteEnde);

        // If only the folio is given
        if (
            ($folioStart) &&
            ($seiteStart == null) && ($folioEnde == null) && ($seiteEnde == null)
        ) {

            return $this->getManuskriptseitenInRangeFromFolio($folioStart);
        }

        // If only starting folio and page are given
        if (
            ($folioStart) && ($seiteStart) &&
            ($folioEnde == null) && ($seiteEnde == null)
        ) {

            return $this->getManuskriptseitenInRangeFromPage($folioStart, $seiteStart);
        }

        // When all parameters are given
        if (($folioStart) && ($seiteStart) && ($folioEnde) && ($seiteEnde)) {

            return $this->getManuskriptseitenInRangeFromPage($folioStart, $seiteStart)
                ->intersect($this->getManuskriptseitenInRangeToPage($folioEnde, $seiteEnde));
        }

        return $this->manuscriptPages;
    }


    /**
     * Get qur'anic mappings of this manuskript
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mappings()
    {
        return $this->hasMany(ManuscriptMapping::class, 'manuscript_id', 'id');
    }

    /**
     * Get Place (holding institution) of manuscript
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }


    /**
     * Get Original Codex of manuscript
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function originalCodex()
    {
        return $this->hasOne(ManuscriptOriginalCodex::class, 'id', 'original_codex_id');
    }

    /**
     * Get Colophon Translation of manuscript
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colophonTranslations()
    {
        return $this->hasMany(ManuscriptColophonTranslation::class, 'manuscript_id', 'id');
    }


    /**
     * Get Palimpsest Translation of manuscript
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function palimpsestTranslations()
    {
        return $this->hasMany(ManuscriptPalimpsestTranslation::class, 'manuscript_id', 'id');
    }


    /**
     * Get Sajda Signs Translation of manuscript
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sajdaSignsTranslations()
    {
        return $this->hasMany(ManuscriptSajdaSignsTranslation::class, 'manuscript_id', 'id');
    }

    public function getCorpusCoranicumLinkAttribute()
    {
        return "http://corpuscoranicum.de" .
            "/manuscripts/{$this->attributes["id"]}";
    }

    public function getAllFoliosAttribute()
    {

        return $this->manuscriptPages
            ->map(function ($manuscriptPage) {

                if (empty($manuscriptPage->page_side)) {
                    return $manuscriptPage->folio;
                }

                return $manuscriptPage->folio . ":" . $manuscriptPage->page_side;
            });
    }

    /**
     * Get all IIIF canvases for the associated manuscript pages
     */
    public function getIiifCanvasesAttribute()
    {
        return $this->manuscriptPages->pluck("firstIiifCanvas");
    }

    public function getFirstIiifCanvasAttribute()
    {
        return $this->iiifCanvases->first();
    }

    /**
     * Generate a IIIF sequence manifest
     */
    public function getIiifSequenceAttribute()
    {
        $sequenceIdentifier = $this->pid;

        $sequence = new IiifSequence($this->pid);

        $sequence->canvases = $this->iiifCanvases;

        return $sequence->generateContent();
    }

    public function getIiifThumbnailAttribute()
    {

        // Get first image of first manuscript page
        $firstImage = $this->manuscriptPages->first()->bilder->first();

        return $firstImage->iiifThumbnail;
    }

    public function getIiifManifestAttribute()
    {
        $manifestIdentifier = $this->pid;

        $manifest = new IiifManifest($manifestIdentifier);

        $manifest->label = $this->Kodextitel;

        $manifest->thumbnail = $this->iiifThumbnail;

        $manifest->sequences = $this->iiifSequence;

        return $manifest->generateContent();
    }


    public function chronology()
    {

        $chronoArray = array();

        $suren = new Sure();

        foreach ($this->mappings as $koranstelle) {

            for ($sure = $koranstelle->sura_start; $sure <= $koranstelle->sura_end; $sure++) {

                array_push($chronoArray, $suren->getChronology($sure));
            }
        }

        $chronoArray = array_unique($chronoArray);

        sort($chronoArray);

        return $chronoArray;
    }

    /**
     * Update the mapping of a manuscript by the manuscript mappings
     *
     * @param $manuskriptId
     * @param ManuskriptseitenMapping $manuskriptseitenMapping
     */

    public function updateManuskriptMapping()
    {

        $manuscriptId = $this->id;

        // Get manuscript pages
        //		$manuscriptPages = ManuscriptNew::find($manuscriptId)->manuscriptPages()->where("folio", ">", 0)->orderBy("TextstelleKoran")->get();
        $manuscriptPages = ManuscriptNew::find($manuscriptId)->manuscriptPages()->where("folio", ">", 0)->get(); //TODO

        // Get manuscript mapping
        $manuscriptMappings = ManuscriptNew::find($manuscriptId)->mappings;

        // Set initial index counter
        $mappingCounter = 0;

        // Iterate over all manuscript pages

        //for ($pageCounter = 0; $pageCounter < sizeof($manuskriptseiten); $pageCounter++)
        foreach ($manuscriptPages as $pageCounter => $manuscriptPage) {

            $manuscriptPageMappings = $manuscriptPage->mappings;

            if ($manuscriptPageMappings->isEmpty()) {
                continue;
            }

            // Iterate over all mappings of the manuscript page

            //for ($pageMappingCounter = 0; $pageMappingCounter < sizeof($manuscriptPageMappings); $pageMappingCounter++)
            foreach ($manuscriptPageMappings as $pageMappingCounter => $manuscriptPageMapping) {

                // Set the first manuscript mapping entry equal to the first manuscript page mapping entry
                if (($pageCounter == 0 && $pageMappingCounter == 0) || $manuscriptMappings->isEmpty()) {


                    // Set first manuscript mapping equal to the first manuscript page mapping
                    if ($manuscriptMappings->isEmpty()) {
                        $newMapping = new ManuscriptMapping();
                        $newMapping["manuscript_id"] = $manuscriptId;
                        $newMapping["sura_start"] = $manuscriptPageMappings[$pageMappingCounter]["sura_start"];
                        $newMapping["verse_start"] = $manuscriptPageMappings[$pageMappingCounter]["verse_start"];
                        $newMapping["sura_end"] = $manuscriptPageMappings[$pageMappingCounter]["sura_end"];
                        $newMapping["verse_end"] = $manuscriptPageMappings[$pageMappingCounter]["verse_end"];

                        $manuscriptMappings->add($newMapping);
                    } else {

                        $manuscriptMappings[$mappingCounter]["sura_start"] = $manuscriptPageMappings[$pageMappingCounter]["sura_start"];
                        $manuscriptMappings[$mappingCounter]["verse_start"] = $manuscriptPageMappings[$pageMappingCounter]["verse_start"];
                        $manuscriptMappings[$mappingCounter]["sura_end"] = $manuscriptPageMappings[$pageMappingCounter]["sura_end"];
                        $manuscriptMappings[$mappingCounter]["verse_end"] = $manuscriptPageMappings[$pageMappingCounter]["verse_end"];
                    }

                    continue;
                }


                // Create new Koranstelle for testing (see next comment)
                $nextStelle = new Koranstelle();
                $nextStelle->sure = $manuscriptMappings[$mappingCounter]["sura_end"];
                $nextStelle->vers = $manuscriptMappings[$mappingCounter]["verse_end"];


                // Get current ManuscriptMapping for testing and convert it into a ManuskriptseitenMapping
                $currentMapping = $manuscriptMappings[$mappingCounter]->toManuskriptseitenMapping();

                // Check whether the manuscripts overlap
                if (
                    $currentMapping->inRange($manuscriptPageMappings[$pageMappingCounter]) ||
                    $manuscriptPageMappings[$pageMappingCounter]->inRange($currentMapping)
                ) {


                    $manuscriptMappings[$mappingCounter]->overlapExtend($manuscriptPageMappings[$pageMappingCounter]);
                    // echo $manuscriptMappings[$mappingCounter] . "\n";

                } // If they are not subsequent, update/add next mapping
                else {
                    // Increment mapping counter
                    $mappingCounter++;

                    // If the mapping counter is greather than the number of manuscript mappings,
                    // add a new one.
                    if (($mappingCounter + 1) > sizeof($manuscriptMappings)) {

                        $newMapping = new ManuscriptMapping();
                        $newMapping["manuscript_id"] = $manuscriptId;
                        $newMapping["sura_start"] = $manuscriptPageMappings[$pageMappingCounter]["sura_start"];
                        $newMapping["verse_start"] = $manuscriptPageMappings[$pageMappingCounter]["verse_start"];
                        $newMapping["sura_end"] = $manuscriptPageMappings[$pageMappingCounter]["sura_end"];
                        $newMapping["verse_end"] = $manuscriptPageMappings[$pageMappingCounter]["verse_end"];

                        $manuscriptMappings->add($newMapping);
                    } // Else update the next one
                    else {
                        $manuscriptMappings[$mappingCounter]["sura_start"] = $manuscriptPageMappings[$pageMappingCounter]["sura_start"];
                        $manuscriptMappings[$mappingCounter]["verse_start"] = $manuscriptPageMappings[$pageMappingCounter]["verse_start"];
                        $manuscriptMappings[$mappingCounter]["sura_end"] = $manuscriptPageMappings[$pageMappingCounter]["sura_end"];
                        $manuscriptMappings[$mappingCounter]["verse_end"] = $manuscriptPageMappings[$pageMappingCounter]["verse_end"];
                    }
                }
            }
        }


        if (count($manuscriptMappings)) {
            // Now save all mappings
            for ($i = 0; $i <= $mappingCounter; $i++) {
                $manuscriptMappings[$i]->save();
            }
        }


        // Delete all unneccesary mappings
        for ($i = sizeof($manuscriptMappings) - 1; $i > $mappingCounter; $i--) {
            $manuscriptMappings[$i]->delete();
        }

        $manuscript = ManuscriptNew::find($manuscriptId);
        //		$manuscript->TextstelleKoran = $this->extractTextstelle($manuscript->mappings);

        $manuscript->save();
    }

    public function removeAllImages()
    {

        $manuscriptPages = $this->manuscriptPages;

        foreach ($manuscriptPages as $manuscriptPage) {

            $bilder = $manuscriptPage->bilder;

            foreach ($bilder as $bild) {

                $bild->delete();
            }
        }
    }

    public function getFilenameAttribute()
    {

        $filename = str_replace([",", " ", ".", ":"], "_", $this->getNameString());

        return $filename;
    }


    /**
     * Extract the quran text ranges for this manuscript
     *
     * @param $mappings
     * @return string
     */
    public function extractTextstelle()
    {

        $mappings = $this->mappings;
        // Create new Textstelle
        $textstelleString = "";

        // Iterate over all textstellen supplied by the user
        for ($i = 0; $i < count($mappings); $i++) {
            $textstelleString .=
                str_pad($mappings[$i]["sura_start"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["verse_start"], 3, 0, STR_PAD_LEFT) . "-" .
                str_pad($mappings[$i]["sura_end"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["verse_end"], 3, 0, STR_PAD_LEFT);

            if (($i + 1) < count($mappings)) {
                $textstelleString .= "; ";
            }
        }

        // Arrange textstellen in ascending order
        $textstelleSort = explode(";", $textstelleString);
        natsort($textstelleSort);
        $textstelleString = implode(";", $textstelleSort);

        return $textstelleString;
    }

    public function getEverythingIsOnlineAttribute()
    {

        if ($this->attributes["is_online"] < 2) {
            return false;
        }

        foreach ($this->manuscriptPages as $manuscriptPage) {

            if ($manuscriptPage->is_online < 2) {
                return false;
            }

            foreach ($manuscriptPage->images as $image) {
                if ($image->is_online < 2) {
                    return false;
                }
            }
        }


        return true;
    }


    /**
     * Create new manuscript pages for a given page number (or range)
     *
     * @param $folioStart
     * @param $seiteStart
     * @param null $folioEnde
     * @param null $seiteEnde
     */
    public function createNewManuscriptPages($folioStart, $seiteStart, $folioEnde = null, $seiteEnde = null)
    {

        if (!$folioEnde) {
            $folioEnde = $folioStart;
        }
        if (!$seiteEnde) {
            $seiteEnde = $seiteStart;
        }

        ManuscriptNew::protectAgainstIllegalPageQuery($folioStart, $seiteStart, $folioEnde, $seiteEnde);

        $newPages = ManuscriptNew::createPageRange($folioStart, $seiteStart, $folioEnde, $seiteEnde);

        foreach ($newPages as $newPage) {

            if ($this->manuscriptPages()->get()->where("folio", $newPage["folio"])->where("page_side", $newPage["page_side"])->count()) {
                continue;
            };
            if ($this->manuscriptPages()->get()->where("folio", strval($newPage["folio"]))->where("page_side", $newPage["page_side"])->count()) {
                continue;
            };

            $manuscriptPage = new ManuscriptPage([
                "folio" => $newPage["folio"],
                "page_side" => $newPage["page_side"],
                //                "FolioundSeite" => $newPage["folio"] . $newPage["page"],
                //                "TextstelleKoran" => "",
                "is_online" => 0
            ]);


            $this->manuscriptPages()->save($manuscriptPage);
        }
    }

    /**
     * Get all pages with their id and folio/page number
     * @return \Illuminate\Support\Collection
     */
    public function getManuscriptPagesAndIds()
    {
        return collect($this->manuscriptPages->map(function (ManuscriptPage $page) {
            return [
                "id" => $page->id,
                "page_side" => "{$page->folio}{$page->page_side}"
            ];
        }))
            ->sortBy("page_side")
            ->pluck("page_side", "id");
    }

    public static function createPageRange($folioStart, $seiteStart, $folioEnde, $seiteEnde)
    {

        ManuscriptNew::protectAgainstIllegalPageQuery($folioStart, $seiteStart, $folioEnde, $seiteEnde);

        $pages = [];

        $counterFolio = $folioStart;
        $counterSeite = $seiteStart;

        while ($counterFolio != $folioEnde || $counterSeite != $seiteEnde) {

            $page = [
                "folio" => $counterFolio,
                "page_side" => $counterSeite
            ];

            array_push($pages, $page);

            if ($counterSeite == "r") {
                $counterSeite = "v";
            } else if ($counterSeite == "v") {
                $counterFolio += 1;
                $counterSeite = "r";
            }

            // Count bis to ter
            if ($counterSeite == "bis") {
                $counterSeite = "ter";
            }

            // count bis r to bis v
            if ($counterSeite == "bis r") {
                $counterSeite = "bis v";
            }

            if ($counterSeite == "ter r") {
                $counterSeite = "ter v";
            }
        }

        // Add last page
        $page = [
            "folio" => $counterFolio,
            "page_side" => $counterSeite
        ];

        array_push($pages, $page);

        return $pages;
    }


    public function provenances()
    {
        return $this->belongsToMany(Provenance::class,
            ManuscriptProvenance::class,
            'manuscript_id',
            'provenance_id');
    }

    public function rwtProvenances()
    {
        return $this->belongsToMany(Provenance::class,
            ManuscriptRWTProvenance::class,
            'manuscript_id',
            'provenance_id');
    }
    public function funders()
    {
        return $this->belongsToMany(Funder::class,
            ManuscriptFunder::class,
            'manuscript_id',
            'funder_id');
    }

    public function readingSigns()
    {
        return $this->belongsToMany(
            ReadingSign::class,
            ManuscriptReadingSign::class,
            "manuscript_id",
            "reading_sign_id");
    }

    public function attributedTo()
    {
        return $this->belongsToMany(
            Attribution::class,
            ManuscriptAttributedTo::class,
            "manuscript_id",
            "attributed_to_id");
    }

    public function verseSegmentations()
    {
        return $this->belongsToMany(
            VerseSegmentation::class,
            ManuscriptVerseSegmentation::class,
            "manuscript_id",
            "verse_segmentation_id");
    }

    /**
     * Get associated reading signs function
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function readingSignsFunctions()
    {
        return $this->hasMany(ManuscriptReadingSignsFunction::class, "manuscript_id", "id");
    }

    /**
     * Get available reading signs function
     * @return array
     */
    public static function getReadingSignsFunctions()
    {
        return self::$optionsReadingSignsFunction;
    }

    public function authors()
    {
        return $this->belongsToMany(
            CCAuthorRole::class,
            "ms_manuscript_author_roles",
            "manuscript_id",
            'author_role_id',
        )->using(ManuscriptAuthor::class);
    }


    /**
     * Get available auction houses
     * @return array
     */
    public static function getAuctionHouses()
    {
        return array_column(AntiquityMarket::all()->all(), 'auction_house', 'id');
    }

    /**
     * Get available currencies
     * @return array
     */
    public static function getCurrencies()
    {
        return self::$optionsCurrency;
    }

    /**
     * Get associated antiquity market
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function antiquityMarkets()
    {
        return $this->hasMany(ManuscriptAntiquityMarket::class, "manuscript_id", "id");
    }

    public function scriptStyles()
    {
        return $this->belongsToMany(ScriptStyle::class,
            ManuscriptScriptStyle::class, "manuscript_id", "style_id");
    }


    public function diacritics()
    {
        return $this->belongsToMany(
            Diacritic::class,
            ManuscriptDiacritic::class,
            "manuscript_id",
            "diacritic_id");
    }
    /**
     * Get available diacritics
     * @return array
     */
    public static function getDiacritics()
    {
        return array_column(Diacritic::all()->all(), 'id', 'diacritic');
    }

    /**
     * Get generated name
     * @return String
     */
    public function getName()
    {
        $place = $this->place ? $this->place->place_name . ": " : "";

        return $place . $this->call_number;

    }

    public function getFullNameAttribute()
    {
        //        $originalCodex = $this->originalCodex ? $this->originalCodex->original_codex_name: "no sister leave assigned yet";
        return "{$this->id} - {$this->getNameString()} - {$this->originalCodex->original_codex_name}";
    }


    /**
     * Cast all items to an array for select boxes
     * @return array
     */
    public static function toSelectArray()
    {
        //        $selectArray = array_map(function ($manuscript) {return $manuscript->getNameString();}, self::all());
        $selectArray = self::whereNotNull('original_codex_id')->get()->pluck("fullName", "id")->toArray();

        return $selectArray;
    }

    /**
     * Hijri Date to Gregorian Date
     * @return array
     */
    public static function hijriToGregorianDate($date)
    {
        $hijriDate = explode("-", $date);
        $gregorianDate = \GeniusTS\HijriDate\Hijri::convertToGregorian($hijriDate[2], $hijriDate[1], $hijriDate[0]);
        $gregorianDate = $gregorianDate->year . "-" . $gregorianDate->month . "-" . $gregorianDate->day;

        return $gregorianDate;
    }

    /**
     * Hijri Date to Gregorian Date
     * @return array
     */
    public static function gregorianToHijriDate($date)
    {
        if ($date == null) return null;
        $hijriDate = \GeniusTS\HijriDate\Hijri::convertToHijri($date);
        $hijriDate = $hijriDate->year . "-" . $hijriDate->month . "-" . $hijriDate->day;

        return $hijriDate;
    }
}
