<?php

namespace App\Models\Manuskripte;

use App\Models\Koranstelle;
use App\Models\PersistentIdentifier;
use App\Models\Sure;
use Chumper\Zipper\Zipper;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Database\Eloquent\Model;
use App\Models\Helpers\IiifManifest;
use App\Models\Helpers\IiifSequence;
use Illuminate\Support\Facades\Cache;
use Storage;

/**
 * App\Models\Manuskripte\Manuskript
 *
 * @property int $ID
 * @property string $Kodextitel
 * @property string $Format
 * @property string $Umfang
 * @property string $Aufbewahrungsort
 * @property int $AufbewahrungsortId
 * @property string $Signatur
 * @property string $Herkunftsort
 * @property string $Datierung
 * @property string $TextstelleKoran
 * @property string $Materialzustand
 * @property string $Zeilenzahl
 * @property string $Fundort
 * @property string $Textspiegel
 * @property string $Materialart
 * @property string $Kodikologie
 * @property string $Schriftduktus
 * @property string $Palaographie
 * @property string $Textgliederung
 * @property string $Literatur
 * @property string $Bearbeiter
 * @property string $Text
 * @property string $Bild
 * @property string $Kommentar_intern
 * @property string $Kommentar
 * @property string $webtauglich
 * @property string $Ornamente
 * @property string $Bildnachweis
 * @property string|null $remarks_additional_folio
 * @property string|null $remarks_foliation
 * @property string|null $remarks_pagination
 * @property string|null $transliteration_alt
 * @property-read \App\Models\Manuskripte\Aufbewahrungsort $aufbewahrungsort
 * @property-read mixed $all_folios
 * @property-read mixed $corpus_coranicum_link
 * @property-read mixed $everything_is_online
 * @property-read mixed $filename
 * @property-read mixed $first_iiif_canvas
 * @property-read mixed $iiif_canvases
 * @property-read mixed $iiif_manifest
 * @property-read mixed $iiif_sequence
 * @property-read mixed $iiif_thumbnail
 * @property-read mixed $pid
 * @property-read mixed $variant_reading_features_by_feature
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Manuskripte\Manuskriptseite[] $manuskriptseiten
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Manuskripte\ManuskriptMapping[] $mappings
 * @property-read \App\Models\PersistentIdentifier $persistentIdentifier
 * @property-write mixed $textstelle_koran
 * @property-read \Illuminate\Database\Eloquent\Collection|ManuskriptVariantReadingFeature[] $variantReadingFeatures
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereAufbewahrungsort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereAufbewahrungsortId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereBearbeiter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereBild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereBildnachweis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereDatierung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereFundort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereHerkunftsort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereKodextitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereKodikologie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereKommentar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereKommentarIntern($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereLiteratur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereMaterialart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereMaterialzustand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereOrnamente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript wherePalaographie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereRemarksAdditionalFolio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereRemarksFoliation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereRemarksPagination($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereSchriftduktus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereSignatur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereTextgliederung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereTextspiegel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereTextstelleKoran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereTransliterationAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereUmfang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereWebtauglich($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Manuskript whereZeilenzahl($value)
 * @mixin \Eloquent
 */
class Manuskript extends Model
{

    protected $table = "manuskript";

    protected $primaryKey = "ID";

    protected $fillable = [
        "TextstelleKoran"
    ];

    protected $guarded = [
        "ID"
    ];

    public $timestamps = false;

    /**
     * Attributes that should be edited in a big text editor
     * @return array
     */
    public $editLarge = array(
        "schriftduktus",
        "palaographie",
        "textgliederung",
        "kommentar",
        "kodikologie",
        "ornamente",
        "kommentar_intern",
        "remarks_additional_folio",
        "remarks_foliation",
        "remarks_pagination"
    );


    /**
     * Attributes that should not be shown in the editing view
     *
     * @return array
     */
    public $editIgnore = array(
        "id",
        "aufbewahrungsortid",
        "textstellekoran",
        "literatur",
        "transliteration_alt"
    );

    /**
     * Attributes that need an alternate editing view
     *
     * @return array
     */
    public $editAlter = array(
        "aufbewahrungsort",
        "preferred_image_source"
    );

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['manuskriptseiten'];

    /**
     * Get all Mansuskriptseiten of a manuscript
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function manuskriptseiten()
    {
        return $this->hasMany(Manuskriptseite::class, 'ManuskriptID', "ID")
            ->orderBy("Folio")
            ->orderBy("Seite");
    }

    /**
     * Get all manuscript pages starting from a given folio number
     * @param $folioStart
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getManuskriptseitenInRangeFromFolio($folioStart)
    {
        return $this->manuskriptseiten->filter(function ($seite) use ($folioStart) {
            return intval($seite->Folio) >= $folioStart;
        });
    }

    /**
     * Get all manuscript pages starting from a given folio number and page indicator
     * @param $folioStart
     * @param $seiteStart
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getManuskriptseitenInRangeFromPage($folioStart, $seiteStart)
    {
        if ($seiteStart == "r") {
            return $this->getManuskriptseitenInRangeFromFolio($folioStart);
        } else if ($seiteStart == "v") {
            return $this->manuskriptseiten->filter(function ($seite) use ($folioStart, $seiteStart) {
                return (
                    (intval($seite->Folio) > $folioStart) ||
                    (intval($seite->Folio) == $folioStart && $seite->Seite == "v")
                );
            });
        }

        return [];
    }

    /**
     * Get all manuscript pages up to a given folio number
     * @param $folioEnde
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getManuskriptseitenInRangeToFolio($folioEnde)
    {

        return $this->manuskriptseiten->filter(function ($seite) use ($folioEnde) {
            return intval($seite->Folio) <= $folioEnde;
        });
    }

    /**
     * Get all manuscript pages up to a given folio number and page indicator
     * @param $folioEnde
     * @param $seiteEnde
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getManuskriptseitenInRangeToPage($folioEnde, $seiteEnde)
    {
        if ($seiteEnde == "r") {
            return $this->manuskriptseiten->filter(function ($seite) use ($folioEnde, $seiteEnde) {
                return (
                    (intval($seite->Folio) < $folioEnde) ||
                    (intval($seite->Folio) == $folioEnde && $seite->Seite == "r")
                );
            });
        } else if ($seiteEnde == "v") {
            return $this->getManuskriptseitenInRangeToFolio($folioEnde);
        }
    }


    /**
     * Get all images associated with a manuscript
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllImages()
    {
        return $this->manuskriptseiten->pluck("bilder")->collapse();
    }

    /**
     * Get all unique sources of images
     * @return mixed
     */
    public function getAllImageSources()
    {
        return Cache::remember("manuscript-image-sources-{$this->ID}", 10040, function () {
            return collect($this->getAllImages()->pluck("Bildlinknachweis"))->unique();
        });
    }

    /**
     * Validate for correct folio and page queries
     * @param $folioStart
     * @param $seiteStart
     * @param $folioEnde
     * @param $seiteEnde
     * @throws QueryException
     */
    private static function protectAgainstIllegalPageQuery($folioStart, $seiteStart, $folioEnde, $seiteEnde)
    {

        if ($folioStart > $folioEnde && $folioStart && $folioEnde) {
            throw new QueryException("The ending boundaries are lower than the starting boundaries");
        }

        if (($folioStart == $folioEnde) &&
            ($seiteStart == "v") &&
            ($seiteEnde == "r") &&
            $folioStart &&
            $folioEnde &&
            $seiteStart &&
            $seiteEnde
        ) {
            throw new QueryException(
                "The folio is the same, but 'v' may not be the starting page if 'r' is the ending page (v.v.)"
            );
        }

        if (!(in_array($seiteStart, ["", "r", "v"]) || in_array($seiteEnde, ["", "r", "v"]) ||
            starts_with($seiteStart, "bis") || starts_with($seiteStart, "ter") ||
            starts_with($seiteEnde, "bis") || starts_with($seiteEnde, "ter")
        )) {
            throw new QueryException(
                "The page name must be 'r', 'v', or must include 'bis' or 'ter' for mass assignment." .
                    "You have: start - " . $seiteStart . " / end - " . $seiteEnde
            );
        }
    }

    /**
     * Get all manuscript pages within a given folio and page range
     * @param null $folioStart
     * @param null $seiteStart
     * @param null $folioEnde
     * @param null $seiteEnde
     * @return Manuskriptseite[]|array|\Illuminate\Database\Eloquent\Collection
     * @throws QueryException
     */
    public function getManuskriptseitenInRange(
        $folioStart = null,
        $seiteStart = null,
        $folioEnde = null,
        $seiteEnde = null
    ) {
        // When no parameters are given, then return all manuscript pages
        if (($folioStart == null) && ($seiteStart == null) && ($folioEnde == null) && ($seiteEnde == null)) {
            return $this->manuskriptseiten;
        }

        // Protect against illegal queries
        $this->protectAgainstIllegalPageQuery($folioStart, $seiteStart, $folioEnde, $seiteEnde);

        // If only the folio is given
        if (($folioStart) &&
            ($seiteStart == null) && ($folioEnde == null) && ($seiteEnde == null)
        ) {
            return $this->getManuskriptseitenInRangeFromFolio($folioStart);
        }

        // If only starting folio and page are given
        if (($folioStart) && ($seiteStart) &&
            ($folioEnde == null) && ($seiteEnde == null)
        ) {
            return $this->getManuskriptseitenInRangeFromPage($folioStart, $seiteStart);
        }

        // When all parameters are given
        if (($folioStart) && ($seiteStart) && ($folioEnde) && ($seiteEnde)) {
            return $this->getManuskriptseitenInRangeFromPage($folioStart, $seiteStart)
                ->intersect($this->getManuskriptseitenInRangeToPage($folioEnde, $seiteEnde));
        }

        return $this->manuskriptseiten;
    }


    /**
     * Get qur'anic mappings of this manuskript
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mappings()
    {
        return $this->hasMany(ManuskriptMapping::class, 'manuskript', 'ID');
    }

    /**
     * Get Aufbewahrungsort (holding institution) of manuscript
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function aufbewahrungsort()
    {
        return $this->hasOne(Aufbewahrungsort::class, 'id', 'AufbewahrungsortId');
    }

    /**
     * Update the text coordinate
     * @param $textstelle
     */
    public function setTextstelleKoranAttribute($textstelle)
    {
        $this->attributes["TextstelleKoran"] = $textstelle;
    }

    /**
     * Get the associated persistent identifier record of this manuscript
     * @return mixed
     */
    public function persistentIdentifier()
    {
        return $this
            ->hasOne(PersistentIdentifier::class, 'original_id', 'ID')
            ->where('original_relation', 'manuskript');
    }

    /**
     * Get the associated PID (Persistent Identifier) value of this manuscript
     * @return string
     */
    public function getPidAttribute()
    {
        return $this->persistentIdentifier->pid;
    }

    /**
     * Get associated manuscript variant reading features
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variantReadingFeatures()
    {
        return $this->hasMany(ManuskriptVariantReadingFeature::class, 'manuskript_id', 'ID');
    }

    /**
     * Get all variant readings in subsequent manuscript pages, grouped by the features
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVariantReadingFeaturesByFeatureAttribute()
    {

        return $this->variantReadingFeatures->groupBy("feature");
    }

    /** Generate the URL to the Corpus Coranicum website
     * @return bool
     */
    public function getCorpusCoranicumLinkAttribute()
    {
        if (!$this->manuskriptseiten->isEmpty()) {
            return $this->manuskriptseiten->first()->corpusCoranicumLink;
        }

        return false;
    }

    /**
     * Get all folio and page values existing for this manuscript record
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllFoliosAttribute()
    {

        return $this->manuskriptseiten
            ->map(function ($manuskriptseite) {
                if (empty($manuskriptseite->Seite)) {
                    return $manuskriptseite->Folio;
                }
                return $manuskriptseite->Folio . ":" . $manuskriptseite->Seite;
            });
    }

    /**
     * Get all IIIF canvases for the associated manuscript pages
     * @return mixed
     */
    public function getIiifCanvasesAttribute()
    {
        return $this->manuskriptseiten->pluck("firstIiifCanvas");
    }

    /**
     * Get the first IIIF canvas, e.g. for a thumbnail
     * @return mixed
     */
    public function getFirstIiifCanvasAttribute()
    {
        return $this->iiifCanvases->first();
    }

    /**
     * Generate a IIIF sequence manifest
     */
    public function getIiifSequenceAttribute()
    {
        $sequence = new IiifSequence($this->pid);

        $sequence->canvases = $this->iiifCanvases;

        return $sequence->generateContent();
    }

    /**
     * Get the IIIF thumbnail of this manuscript, usually the first manuscript page
     * @return mixed
     */
    public function getIiifThumbnailAttribute()
    {
        // Get first image of first manuscript page
        $firstImage = $this->manuskriptseiten->first()->bilder->first();

        return $firstImage->iiifThumbnail;
    }

    /**
     * Generate a IIIF manifest for this record
     * @return array
     */
    public function getIiifManifestAttribute()
    {
        $manifestIdentifier = $this->pid;

        $manifest = new IiifManifest($manifestIdentifier);

        $manifest->label = $this->Kodextitel;

        $manifest->thumbnail = $this->iiifThumbnail;

        $manifest->sequences = $this->iiifSequence;

        return $manifest->generateContent();
    }


    /**
     * Put the text coordinate order into the correct timeline
     * @return array
     */
    public function chronology()
    {
        $chronoArray = array();

        $suren = new Sure();

        foreach ($this->mappings as $koranstelle) {
            for ($sure = $koranstelle->sure_start; $sure <= $koranstelle->sure_ende; $sure++) {
                array_push($chronoArray, $suren->getChronology($sure));
            }
        }

        $chronoArray = array_unique($chronoArray);

        sort($chronoArray);

        return $chronoArray;
    }

    /**
     * Update the mapping of a manuscript by the manuscript mappings
     */

    public function updateManuskriptMapping()
    {
        $manuskriptId = $this->ID;

        // Get manuscript pages
        $manuskriptseiten = Manuskript::find($manuskriptId)
            ->manuskriptseiten()
            ->where("Folio", ">", 0)
            ->orderBy("TextstelleKoran")
            ->get();

        // Get manuscript mapping
        $manuscriptMappings = Manuskript::find($manuskriptId)->mappings;

        // Set initial index counter
        $mappingCounter = 0;

        // Iterate over all manuscript pages

        //for ($pageCounter = 0; $pageCounter < sizeof($manuskriptseiten); $pageCounter++)
        foreach ($manuskriptseiten as $pageCounter => $manuskriptseite) {
            $manuscriptPageMappings = $manuskriptseite->mappings;

            if ($manuscriptPageMappings->isEmpty()) {
                continue;
            }

            // Iterate over all mappings of the manuscript page

            foreach ($manuscriptPageMappings as $pageMappingCounter => $manuscriptPageMapping) {
                // Set the first manuscript mapping entry equal to the first manuscript page mapping entry
                if (($pageCounter == 0 && $pageMappingCounter == 0) || $manuscriptMappings->isEmpty()) {
                    // Set first manuscript mapping equal to the first manuscript page mapping
                    if ($manuscriptMappings->isEmpty()) {
                        $newMapping = new ManuskriptMapping();
                        $newMapping["manuskript"] = $manuskriptId;
                        $newMapping["sure_start"] = $manuscriptPageMappings[$pageMappingCounter]["sure_start"];
                        $newMapping["vers_start"] = $manuscriptPageMappings[$pageMappingCounter]["vers_start"];
                        $newMapping["sure_ende"] = $manuscriptPageMappings[$pageMappingCounter]["sure_ende"];
                        $newMapping["vers_ende"] = $manuscriptPageMappings[$pageMappingCounter]["vers_ende"];

                        $manuscriptMappings->add($newMapping);
                    } else {
                        $manuscriptMappings[$mappingCounter]["sure_start"] =
                            $manuscriptPageMappings[$pageMappingCounter]["sure_start"];

                        $manuscriptMappings[$mappingCounter]["vers_start"] =
                            $manuscriptPageMappings[$pageMappingCounter]["vers_start"];

                        $manuscriptMappings[$mappingCounter]["sure_ende"] =
                            $manuscriptPageMappings[$pageMappingCounter]["sure_ende"];

                        $manuscriptMappings[$mappingCounter]["vers_ende"] =
                            $manuscriptPageMappings[$pageMappingCounter]["vers_ende"];
                    }

                    continue;
                }


                // Create new Koranstelle for testing (see next comment)
                $nextStelle = new Koranstelle();
                $nextStelle->sure = $manuscriptMappings[$mappingCounter]["sure_ende"];
                $nextStelle->vers = $manuscriptMappings[$mappingCounter]["vers_ende"];


                // Get current ManuscriptMapping for testing and convert it into a ManuskriptseitenMapping
                $currentMapping = $manuscriptMappings[$mappingCounter]->toManuskriptseitenMapping();

                // Check whether the manuscripts overlap
                if (
                    $currentMapping->inRange($manuscriptPageMappings[$pageMappingCounter]) ||
                    $manuscriptPageMappings[$pageMappingCounter]->inRange($currentMapping)
                ) {
                    $manuscriptMappings[$mappingCounter]->overlapExtend($manuscriptPageMappings[$pageMappingCounter]);
                } else {
                    // If they are not subsequent, update/add next mapping
                    // Increment mapping counter
                    $mappingCounter++;

                    // If the mapping counter is greather than the number of manuscript mappings,
                    // add a new one.
                    if (($mappingCounter + 1) > sizeof($manuscriptMappings)) {
                        $newMapping = new ManuskriptMapping();
                        $newMapping["manuskript"] = $manuskriptId;
                        $newMapping["sure_start"] = $manuscriptPageMappings[$pageMappingCounter]["sure_start"];
                        $newMapping["vers_start"] = $manuscriptPageMappings[$pageMappingCounter]["vers_start"];
                        $newMapping["sure_ende"] = $manuscriptPageMappings[$pageMappingCounter]["sure_ende"];
                        $newMapping["vers_ende"] = $manuscriptPageMappings[$pageMappingCounter]["vers_ende"];

                        $manuscriptMappings->add($newMapping);
                    } else {
                        // Else update the next one
                        $manuscriptMappings[$mappingCounter]["sure_start"] =
                            $manuscriptPageMappings[$pageMappingCounter]["sure_start"];

                        $manuscriptMappings[$mappingCounter]["vers_start"] =
                            $manuscriptPageMappings[$pageMappingCounter]["vers_start"];

                        $manuscriptMappings[$mappingCounter]["sure_ende"] =
                            $manuscriptPageMappings[$pageMappingCounter]["sure_ende"];

                        $manuscriptMappings[$mappingCounter]["vers_ende"] =
                            $manuscriptPageMappings[$pageMappingCounter]["vers_ende"];
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

        $manuscript = Manuskript::find($manuskriptId);
        $manuscript->TextstelleKoran = $this->extractTextstelle($manuscript->mappings);

        $manuscript->save();
    }

    public function removeAllImages()
    {
        $manuskriptseiten = $this->manuskriptseiten;

        foreach ($manuskriptseiten as $manuskriptseite) {
            $bilder = $manuskriptseite->bilder;

            foreach ($bilder as $bild) {
                $bild->delete();
            }
        }
    }

    /**
     * Generate a filename for this manuscript derived from its metadata
     * @return mixed
     */
    public function getFilenameAttribute()
    {
        $filename = str_replace([",", " ", ".", ":"], "_", $this->attributes["Kodextitel"]);
        return $filename;
    }


    /**
     * Extract the quran text ranges for this manuscript
     *
     * @param $mappings
     * @return string
     */
    private function extractTextstelle($mappings)
    {
        // Create new Textstelle
        $textstelleString = "";

        // Iterate over all textstellen supplied by the user
        for ($i = 0; $i < count($mappings); $i++) {
            $textstelleString .=
                str_pad($mappings[$i]["sure_start"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["vers_start"], 3, 0, STR_PAD_LEFT) . "-" .
                str_pad($mappings[$i]["sure_ende"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["vers_ende"], 3, 0, STR_PAD_LEFT);

            if (($i + 1) < count($mappings)) {
                $textstelleString .= ";";
            }
        }

        // Arrange textstellen in ascending order
        $textstelleSort = explode(";", $textstelleString);
        natsort($textstelleSort);
        $textstelleString = implode(";", $textstelleSort);

        return $textstelleString;
    }

    public function isOnlineAttribute()
    {
        return $this->attributes['webtauglich'] == "ja" ||
            $this->attributes['webtauglich'] == 'ohneBild';
    }


    /**
     * @return string
     * @throws \Throwable
     */
    public function generatePaleocoranXml()
    {
        $manuskript = Manuskript::find($this->ID);

        $xmlPart = view("xml.paleocoran.manuscript-part", [
            "manuskript" => $manuskript
        ])->render();

        Storage::put("paleocoran/tmp/{$manuskript->filename}.xml", $xmlPart);

        foreach ($manuskript->manuskriptseiten as $manuskriptseite) {
            $xmlPage = $manuskriptseite->generatePaleocoranXml();

            Storage::put(
                "paleocoran/tmp/{$manuskript->filename}/f{$manuskriptseite->Folio}{$manuskriptseite->Seite}.xml",
                $xmlPage
            );
        }

        $zipper = new Zipper();

        $zipPath = storage_path("app/{$manuskript->filename}.zip");

        $zipper
            ->make($zipPath)
            ->add(storage_path("app/paleocoran/tmp/"));

        return $zipPath;
    }

    /**
     * Create new manuscript pages for a given page number (or range)
     * @param $folioStart
     * @param $seiteStart
     * @param null $folioEnde
     * @param null $seiteEnde
     * @throws QueryException
     */
    public function createNewManuscriptPages($folioStart, $seiteStart, $folioEnde = null, $seiteEnde = null)
    {
        if (!$folioEnde) {
            $folioEnde = $folioStart;
        }

        if (!$seiteEnde) {
            $seiteEnde = $seiteStart;
        }

        Manuskript::protectAgainstIllegalPageQuery($folioStart, $seiteStart, $folioEnde, $seiteEnde);

        $newPages = Manuskript::createPageRange($folioStart, $seiteStart, $folioEnde, $seiteEnde);

        foreach ($newPages as $newPage) {
            $pageExists = $this->manuskriptseiten()
                ->get()
                ->where("Folio", $newPage["Folio"])
                ->where("Seite", $newPage["Seite"])
                ->count();

            if ($pageExists) {
                continue;
            };

            $pageExistsStr = $this->manuskriptseiten()
                ->get()
                ->where("Folio", strval($newPage["Folio"]))
                ->where("Seite", $newPage["Seite"])
                ->count();

            if ($pageExistsStr) {
                continue;
            };

            $manuskriptseite = new Manuskriptseite([
                "Folio" => $newPage["Folio"],
                "Seite" => $newPage["Seite"],
                "FolioundSeite" => $newPage["Folio"] . $newPage["Seite"],
                "Bearbeiter" => "",
                "Transkription" => "",
                "TextstelleKoran" => "",
                "Zeilenzahl" => "",
                "Kommentar" => "",
                "Kommentar_intern" => "",
                "Palaeographie" => "",
                "webtauglich" => "nein",
                "Format" => "",
                "digilib" => ""
            ]);


            $this->manuskriptseiten()->save($manuskriptseite);
        }
    }

    /**
     * Get all pages with their id and folio/page number
     * @return \Illuminate\Support\Collection
     */
    public function getManuscriptPagesAndIds()
    {
        return collect($this->manuskriptseiten->map(function (Manuskriptseite $page) {
            return [
                "SeitenID" => $page->SeitenID,
                "page" => "{$page->Folio}{$page->Seite}"
            ];
        }))
            ->sortBy("page")
            ->pluck("page", "SeitenID");
    }

    /**
     * Create pages within a given range, if they don't exist yet
     * @param $folioStart
     * @param $seiteStart
     * @param $folioEnde
     * @param $seiteEnde
     * @return array
     * @throws QueryException
     */
    public static function createPageRange($folioStart, $seiteStart, $folioEnde, $seiteEnde)
    {
        Manuskript::protectAgainstIllegalPageQuery($folioStart, $seiteStart, $folioEnde, $seiteEnde);

        $pages = [];

        $counterFolio = $folioStart;
        $counterSeite = $seiteStart;

        while ($counterFolio != $folioEnde || $counterSeite != $seiteEnde) {
            $page = [
                "Folio" => $counterFolio,
                "Seite" => $counterSeite
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
            "Folio" => $counterFolio,
            "Seite" => $counterSeite
        ];

        array_push($pages, $page);

        return $pages;
    }

    /**
     * Get generated name
     * @return String
     */
    public function getPlaceString()
    {
        $place = Aufbewahrungsort::getReadableName($this->AufbewahrungsortId);
        return $place;
    }
    /**
     * Get generated name
     * @return String
     */
    public function getNameString()
    {
        $place = $this->getPlaceString();
        $callNumber = $this->Signatur;
        $name = implode(": ", [$place, $callNumber]);
        return $name;
    }

    /**
     * Get a list of all protected manuscripts which should not be altered
     * @return array
     */
    public static function getProtectedManuscripts()
    {
        return array(
            12, 19, 52, 116, 117, 150, 151, 152, 165, 173, 323, 331, 332,
            333, 391, 392, 393, 394, 395, 396, 397, 398, 399, 400, 401,
            402, 403, 404, 405, 406, 407, 408, 409, 410, 507, 508, 518,
            519, 520, 521, 523, 524, 544, 545, 546, 547, 790, 791, 792,
            793, 794, 795, 796, 797, 798, 799, 800, 801, 802, 803, 804,
            805, 806, 807, 808, 809, 810, 811, 812, 813, 814, 815, 816,
            817, 818, 819, 820, 821, 822, 823, 824, 825, 826
        );
    }
}
