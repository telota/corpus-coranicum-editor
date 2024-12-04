<?php

namespace App\Models\Manuskripte;

use App\Models\Helpers\IiifCanvas;
use App\Models\PersistentIdentifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class Manuskriptseite
 * @package App\Models\Manuskripte
 */
class Manuskriptseite extends Model
{
    protected $table = "manuskriptseiten";

    protected $primaryKey = "SeitenID";

    protected $guarded = [
        "SeitenID"
    ];

    public $timestamps = false;

    /**
     * Get the Manuskript of the current Manuskriptseite
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manuskript()
    {
        return $this->belongsTo(Manuskript::class, "ManuskriptID");
    }

    /**
     * Parameters to be ignored in the editView
     * @return array
     */
    public $editIgnore =
            array(
                "seitenid",
                "bearbeiter",
                "transkription",
                "scaler",
                "digilib",
                "thumb",
                "detail",
                "thumb2",
                "detail2",
                "folioundseite",
                "width",
                'pn'
            );


    /**
     * Parameters to be rendered differently in the editView
     * @var array
     */
    public $editAlter =
            array(
                "bildlink",
                "bildlink2",
                "manuskriptid",
                "seite",
                "textstellekoran",
                "images"
            );


    /**
     * Cast the folio number of this manuscript page to integer
     * @return int
     */
    public function getFolioAsIntAttribute()
    {
        return intval($this->Folio);
    }

    /**
     * Get mappings for this manuscript page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mappings()
    {
        return $this->hasMany(ManuskriptseitenMapping::class, 'manuskriptseite', "SeitenID");
    }

    /**
     * Get Qur'an coordinates which are covered by this manuscript page
     * @return mixed
     */
    public function getKoranstellenAttribute()
    {
        $koranstellen = $this->mappings->pluck("koranstellen")->all()[0];

        return $koranstellen;
    }

    /**
     * Get the verses which are covered on this manuscript page
     * @return mixed
     */
    public function getVerseAttribute()
    {
        $verse = $this->koranstellen->map(function ($koranstelle) {
            return collect(["sure" => $koranstelle->sure, "vers" => $koranstelle->vers]);
        });

        return $verse->unique();
    }

    /**
     * Get images for this manuscript page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bilder()
    {
        return $this->hasMany(ManuskriptseitenBild::class, 'manuskriptseite', 'SeitenID');
    }

    /**
     * Get information about images
     */
    public function getImageInfoAttribute()
    {
        return [
            "folio" => $this->Folio,
            "seite" => $this->Seite,
            "mappings" => $this->mappings->implode("readableCoordinates", ";"),
            "manuscriptPage" => $this->SeitenID,
            "images" => $this->imagesWithIiif
        ];
    }

    /**
     * Map all associated images while including IIIF information
     * @return mixed
     */
    public function getImagesWithIiifAttribute()
    {
        return $this->bilder->map(function ($bild) {
            return [
                "image" => $bild->id,
                "description" => $bild->Bildnachweis,
                "iiif" => $bild->iiifLinkSet
            ];
        });
    }

    /**
     * Get the persistent identifier for this manuscript page
     *
     * @return mixed
     */
    public function persistentIdentifier()
    {
        return $this
            ->hasOne(PersistentIdentifier::class, 'original_id', 'SeitenID')
            ->where('original_relation', 'manuskriptseite');
    }


    /**
     * Select all variant readings by a given feature
     * @param $feature
     * @return mixed
     */
    public function lesartenByFeature($feature)
    {
        return $this
            ->lesarten()
            ->where("feature", $feature)
            ->get();
    }

    /**
     * Get readable label for a given manuscript page
     * @return string
     */
    public function getReadableLabelAttribute()
    {
        $kodextitel = $this->manuskript->Kodextitel;

        return "{$kodextitel}, f. {$this->Folio}{$this->Seite}";
    }

    /**
     * Get basic reading attribute helper
     * @return mixed
     */
    public function getBasicReadingFeaturesAttribute()
    {
        return $this->lesartenByFeature("basic-reading")
            ->pluck("basicReadingFeatures")
            ->collapse()
            ->unique("feature")
            ->pluck("feature");
    }


    /**
     * Get the Persistend Identifier
     *
     * @return mixed
     */
    public function getPidAttribute()
    {
        return $this->persistentIdentifier->pid;
    }

    /**
     * Get a computed file path to an image (deprecated)
     *
     * @return string
     */
    public function getBildPathAttribute()
    {
        return $this->Ordner . "/" . $this->Bildlink;
    }

    /**
     * Get a computed file path to an image (deprecated)
     *
     * @return string
     */
    public function getBildPath2Attribute()
    {
        return $this->Ordner . "/" . $this->Bildlink2;
    }

    /**
     * If the compared mapping ends higher, take thoses values
     * @return mixed
     */
    public function getIiifCanvasesAttribute()
    {
        if ($this->bilder->count()) {
            return $this->bilder->pluck('iiifCanvas');
        }

        $canvas = new ManuskriptseitenBild(["webtauglich" => "nein"]);
        return $canvas->iiifCanvas;

    }

    /**
     * Get first IIIF canvas, e.g. for showing a thumbnail in a collection
     * @return mixed
     */
    public function getFirstIiifCanvasAttribute()
    {
        return Cache::remember("preferred-iiif-canvas-{$this->SeitenID}", 10040, function () {

            if (!$this->bilder->count()) {
                $label = $this->readableLabel;

                $canvas = new IiifCanvas(
                    "null",
                    ManuskriptseitenBild::getFallbackBaseLink(),
                    $label
                );

                //$canvas->iiifBaseLink = $this->iiifDigilibBaseLink;

                return $canvas->generateContent();
            }

            if ($this->manuskript->preferred_image_source) {
                $preferredImage = $this->bilder->where("Bildlinknachweis", $this->manuskript->preferred_image_source);
                if (count($preferredImage)) {
                    if (!empty($preferredImage->iiifCanvas)) {
                        return $preferredImage->iiifCanvas;
                    }
                }
            }

            return $this->bilder->pluck('iiifCanvas')->first();
        });
    }

    /**
     * Summarize all textstellen
     * @param $mappings
     * @return string
     */
    public function extractTextstelle($mappings)
    {
        // Create new Textstelle
        $textstelleString = "";

        // Iterate over all textstellen supplied by the user
        for ($i = 0; $i < count($mappings); $i++) {
            $textstelleString .=
                str_pad($mappings[$i]["sure_start"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["vers_start"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["wort_start"], 3, 0, STR_PAD_LEFT) . "-" .
                str_pad($mappings[$i]["sure_ende"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["vers_ende"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["wort_ende"], 3, 0, STR_PAD_LEFT);

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

    /**
     * Get the next manuscript page
     * @return bool
     */
    public function getNextManuskriptseiteAttribute()
    {
        $nextFolio = $this->attributes["Folio"];
        $nextSeite = $this->attributes["Seite"];

        if ($nextSeite == "r") {
            $nextSeite = "v";
        } elseif ($nextSeite == "v") {
            $nextSeite = Manuskriptseite::where('Folio', $nextFolio)
                ->where('Seite', 'bis r')->first();
            if ($nextSeite === null) {
                $nextFolio += 1;
                $nextSeite = "r";
            } else {
                $nextSeite = $nextSeite->attributes["Seite"];
            }
        } elseif ($nextSeite == 'bis r') {
            $nextSeite = 'bis v';
        } elseif ($nextSeite == 'bis v') {
            $nextSeite = Manuskriptseite::where('Folio', $nextFolio)
                ->where('Seite', '=', 'ter r')->first();
            if ($nextSeite === null) {
                $nextFolio += 1;
                $nextSeite = "r";
            } else {
                $nextSeite = $nextSeite->attributes["Seite"];
            }
        } elseif ($nextSeite == 'ter r') {
            $nextSeite = 'ter v';
        } elseif ($nextSeite == 'ter v') {
            $nextFolio += 1;
            $nextSeite = 'r';
        } elseif (!$nextFolio || !$nextSeite) {
            return false;
        }

        $nextPage = Manuskriptseite::where("ManuskriptID", $this->attributes["ManuskriptID"])
            ->where("Folio", $nextFolio)
            ->where("Seite", $nextSeite)
            ->first();

        return $nextPage;
    }

    /**
     * Get the next manuscript page
     * @return bool
     */
    public function getPreviousManuskriptseiteAttribute()
    {
        $prevFolio = $this->attributes["Folio"];
        $prevSeite = $this->attributes["Seite"];

        if ($prevSeite == 'ter v') {
            $prevSeite = 'ter r';
        } elseif ($prevSeite == 'ter r') {
            $prevSeite = 'bis v';
        } elseif ($prevSeite == 'bis v') {
            $prevSeite = "bis r";
        } elseif ($prevSeite == 'bis r') {
            $prevSeite = 'v';
        } elseif ($prevSeite == 'v') {
            $prevSeite = 'r';
        } elseif ($prevSeite == 'r') {
            $prevFolio -= 1;
            $prevSeite = Manuskriptseite::where("Folio", $prevFolio)
                ->where("Seite", 'ter v')->first();
            if ($prevSeite === null) {
                $prevSeite = Manuskriptseite::where("Folio", $prevFolio)
                    ->where("Seite", 'bis v')->first();
                if ($prevSeite === null) {
                    $prevSeite = 'v';
                    $prevFolio -= 1;
                } else {
                    $prevSeite = $prevSeite->attributes["Seite"];
                }
            } else {
                $prevSeite = $prevSeite->attributes["Seite"];
            }
        } elseif (!$prevFolio || $prevSeite) {
            return false;
        }

        $prevPage = Manuskriptseite::where("ManuskriptID", $this->attributes["ManuskriptID"])
            ->where("Folio", $prevFolio)
            ->where("Seite", $prevSeite)
            ->first();

        return $prevPage;
    }

    /**
     * Generate link to Corpus Coranicum
     * @return bool|string
     */
    public function getCorpusCoranicumLinkAttribute()
    {
        $mapping = $this->mappings->first();

        if (!$mapping) {
            return false;
        }

        $manuscriptLink =
            "http://corpuscoranicum.de/handschriften/index/sure/{$mapping->sure_start}/vers/{$mapping->vers_start}?".
            "handschrift={$this->attributes["ManuskriptID"]}";

        return $manuscriptLink;
    }

    /**
     * Generate the paleocoran XML file for this manuscript page
     * @return string
     * @throws \Throwable
     */
    public function generatePaleocoranXml()
    {
        $manuskriptseite = Manuskriptseite::find($this->SeitenID);

        $xmlPart = view("xml.paleocoran.manuscript-page", [
            "manuskriptseite" => $manuskriptseite
        ])->render();

        return $xmlPart;
    }

}
