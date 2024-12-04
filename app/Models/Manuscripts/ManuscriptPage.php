<?php

namespace App\Models\Manuscripts;

use App\Models\Manuscripts\ManuscriptPageMapping;
use App\Models\PersistentIdentifier;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;


class ManuscriptPage extends Model
{
    use CreatedUpdatedBy;
    protected $table = "ms_manuscript_pages";

    protected $primaryKey = "id";

    protected $guarded = [
        "id"
    ];

    public $timestamps = true;

    protected $attributes = [
        'folio' => null,
        'page_side' => null,
        'is_online' => 0,
    ];
    /**
     * Get the Manuskript of the current Manuskriptseite
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manuscript()
    {
        return $this->belongsTo(ManuscriptNew::class, "manuscript_id");
    }

    /**
     * Cast the folio number of this manuscript page to integer
     * @return int
     */
    public function getFolioAsIntAttribute()
    {
        return intval($this->folio);
    }

    /**
     * Get mappings for this manuscript page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mappings()
    {
        return $this->hasMany(ManuscriptPageMapping::class, 'manuscript_page_id', "id")
            ->orderBy('sura_start')
            ->orderBy('verse_start')
            ->orderBy('word_start');
    }

    /**
     * Get Qur'an coordinates which are covered by this manuscript page
     * @return mixed
     */
    public function getKoranstellenAttribute() //TODO
    {
        $koranstellen = $this->mappings->pluck("koranstellen")->all()[0];

        return $koranstellen;
    }

    /**
     * Get the verses which are covered on this manuscript page
     * @return mixed
     */
    public function getVerseAttribute() //TODO
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
    public function images()
    {
        return $this->hasMany(ManuscriptPageImage::class, 'manuscript_page_id', 'id')
            ->orderBy('sort');
    }

    /**
     * Get information about images
     */
    public function getImageInfoAttribute() //TODO
    {
        return [
            "folio" => $this->folio,
            "seite" => $this->page_side,
            "mappings" => $this->mappings->implode("readableCoordinates", ";"),
            "manuscriptPage" => $this->id,
            "images" => $this->imagesWithIiif
        ];
    }

    /**
     * Map all associated images while including IIIF information
     * @return mixed
     */
    public function getImagesWithIiifAttribute()
    {
        return $this->images->map(function ($bild) {
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
            ->hasOne(PersistentIdentifier::class, 'original_id', 'id')
            ->where('original_relation', 'manuskriptseite');
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
    public function getBildPathAttribute() //TODO
    {
        return $this->Ordner . "/" . $this->Bildlink;
    }

    /**
     * Get a computed file path to an image (deprecated)
     *
     * @return string
     */
    public function getBildPath2Attribute() //TODO
    {
        return $this->Ordner . "/" . $this->Bildlink2;
    }

    /**
     * If the compared mapping ends higher, take thoses values
     * @return mixed
     */
    public function getIiifCanvasesAttribute() //TODO
    {
        return $this->images->pluck('iiifCanvas');
    }

    /**
     * Get first IIIF canvas, e.g. for showing a thumbnail in a collection
     * @return mixed
     */
    public function getFirstIiifCanvasAttribute() //TODO
    {
        return $this->images->pluck('iiifCanvas')->first();
    }

    /**
     * Summarize all textstellen
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
                str_pad($mappings[$i]["verse_start"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["word_start"], 3, 0, STR_PAD_LEFT) . "-" .
                str_pad($mappings[$i]["sura_end"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["verse_end"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["word_end"], 3, 0, STR_PAD_LEFT);

            if (($i + 1) < count($mappings)) {
                $textstelleString .= ";";
            }
        }

        // Arrange textstellen in ascending order
        $textstelleSort = explode(";", $textstelleString);
        natsort($textstelleSort);
        $textstelleString = implode(";", $textstelleSort);
        //dd($textstelleString);
        return $textstelleString;
    }

    /**
     * Get the next manuscript page
     * @return bool
     */
    public function getNextManuskriptseiteAttribute()
    {
        $nextFolio = $this->attributes["folio"];
        $nextSeite = $this->attributes["page_side"];

        if ($nextSeite == "r") {
            $nextSeite = "v";
        } elseif ($nextSeite == "v") {
            $nextSeite = ManuscriptPage::where('folio', $nextFolio)
                ->where('page_side', 'bis r')->first();
            if ($nextSeite === null) {
                $nextFolio += 1;
                $nextSeite = "r";
            } else {
                $nextSeite = $nextSeite->attributes["page_side"];
            }
        } elseif ($nextSeite == 'bis r') {
            $nextSeite = 'bis v';
        } elseif ($nextSeite == 'bis v') {
            $nextSeite = ManuscriptPage::where('folio', $nextFolio)
                ->where('page_side', '=', 'ter r')->first();
            if ($nextSeite === null) {
                $nextFolio += 1;
                $nextSeite = "r";
            } else {
                $nextSeite = $nextSeite->attributes["page_side"];
            }
        } elseif ($nextSeite == 'ter r') {
            $nextSeite = 'ter v';
        } elseif ($nextSeite == 'ter v') {
            $nextFolio += 1;
            $nextSeite = 'r';
        } elseif (!$nextFolio || !$nextSeite) {
            return false;
        }

        $nextPage = ManuscriptPage::where("manuscript_id", $this->attributes["manuscript_id"])
            ->where("folio", $nextFolio)
            ->where("page_side", $nextSeite)
            ->first();

        return $nextPage;
    }

    /**
     * Get the next manuscript page
     * @return bool
     */
    public function getPreviousManuskriptseiteAttribute()
    {
        $prevFolio = $this->attributes["folio"];
        $prevSeite = $this->attributes["page_side"];

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
            $prevSeite = ManuscriptPage::where("folio", $prevFolio)
                ->where("page_side", 'ter v')->first();
            if ($prevSeite === null) {
                $prevSeite = ManuscriptPage::where("folio", $prevFolio)
                    ->where("page_side", 'bis v')->first();
                if ($prevSeite === null) {
                    $prevSeite = 'v';
                    $prevFolio -= 1;
                } else {
                    $prevSeite = $prevSeite->attributes["page_side"];
                }
            } else {
                $prevSeite = $prevSeite->attributes["page_side"];
            }
        } elseif (!$prevFolio || $prevSeite) {
            return false;
        }

        $prevPage = ManuscriptPage::where("manuscript_id", $this->attributes["manuscript_id"])
            ->where("folio", $prevFolio)
            ->where("page_side", $prevSeite)
            ->first();

        return $prevPage;
    }

    /**
     * Generate link to Corpus Coranicum
     * @return bool|string
     */
    public function getCorpusCoranicumLinkAttribute()
    {
        return "http://corpuscoranicum.de" .
            "/manuscripts/{$this->attributes["manuscript_id"]}" .
            "/page/{$this->attributes["folio"]}{$this->attributes["page_side"]}";
    }
}
