<?php

namespace App\Models\Helpers;

use App\Models\Manuskripte\Manuskript;
use App\Models\Manuskripte\Manuskriptseite;
use App\Models\Manuskripte\ManuskriptseitenBild;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

/**
 * Class GallicaDownloader
 * @package use App\Models\Helpers
 */
class GallicaDownloader
{
    protected $baseLink;
    protected $gallicaStart;
    protected $gallicaEnd;
    protected $manuscriptId;
    protected $folioStart;
    protected $seiteStart;
    protected $folioEnd;
    protected $seiteEnd;
    private $timeout;

    const GALLICA_BASE = "http://gallica.bnf.fr/";
    const GALLICA_IIIF = "http://gallica.bnf.fr/iiif/";
    const GALLICA_HI_RES_PARAM = "/full/full/0/native.jpg";
    const GALLICA_CITE = "gallica.bnf.fr / Bibliothèque nationale de France";



    /**
     * GallicaDownloader constructor.
     * @param string $baseLink
     * @param int $gallicaStart
     * @param int $gallicaEnd
     * @param int|null $manuscriptId
     * @param int|null $folioStart
     * @param int|null $seiteStart
     * @param int|null $folioEnd
     * @param int|null $seiteEnd
     * @param int|null $timeout
     */
    public function __construct(
        $baseLink,
        $gallicaStart,
        $gallicaEnd,
        $manuscriptId = null,
        $folioStart = null,
        $seiteStart = null,
        $folioEnd = null,
        $seiteEnd = null,
        $timeout = null
    ) {
        $this->baseLink = $baseLink;
        $this->gallicaStart = $gallicaStart;
        $this->gallicaEnd = $gallicaEnd;
        $this->manuscriptId = $manuscriptId;
        $this->folioStart = $folioStart;
        $this->seiteStart = $seiteStart;
        $this->folioEnd = $folioEnd;
        $this->seiteEnd = $seiteEnd;
        $this->timeout = $timeout;

        $this->protectAgainstIllegalDownloadRange();
    }

    /**
     * Check whether the download instructions provided are valid
     */
    private function protectAgainstIllegalDownloadRange()
    {
        if (!str_contains($this->baseLink, "gallica.bnf.fr")) {
            throw new Exception("No valid Gallica link");
        }

        if ($this->gallicaEnd < $this->gallicaStart) {
            throw new Exception("Start value has to be lower than the end value");
        }

        if ($this->hasPageRange()) {
            $msRange = count(Manuskript::createPageRange(
                $this->folioStart,
                $this->seiteStart,
                $this->folioEnd,
                $this->seiteEnd
            ));
            $gallicaRange = count($this->getGallicaRange());

            if ($msRange != $gallicaRange) {
                throw new Exception(
                    "Gallica Range ({$gallicaRange}) and manuscript range ({$msRange}) have differenz sizes. 
                    See MS {$this->manuscriptId}"
                );
            }
        }
    }

    /**
     * Download all pages
     */
    public function downloadImages()
    {
        $length = count($this->getGallicaRange());
        foreach ($this->getGallicaRange() as $index => $gallicaPageNumber) {
            $counter = $index + 1;
            echo "{$counter}/{$length}\n";
            $this->downloadImage($gallicaPageNumber);
            if ($this->timeout) {
                sleep($this->timeout);
            }
        }
    }

    /**
     * Download image for $pageNumber
     * @param int $pageNumber
     */
    private function downloadImage($pageNumber)
    {
        $downloadLink = $this->getFullImageLink($pageNumber);
        $downloadPath = $this->getDownloadPath($pageNumber);
        $fileDownloaded = false;

        try {
            Storage::disk('silo10')->put($downloadPath, fopen($downloadLink, "r"));
            $fileDownloaded = true;
        } catch (Exception $e) {
            print "Download failed. Trying again...\n";
            $this->downloadImage($pageNumber);
        }


        if ($this->hasPageRange() && $fileDownloaded) {
            $folio = $this->getGallicaPageMap()[$pageNumber]["Folio"];
            $seite = $this->getGallicaPageMap()[$pageNumber]["Seite"];
            $manuskriptseite = Manuskriptseite::firstOrCreate([
                "ManuskriptID" => $this->manuscriptId,
                "Folio" => $folio,
                "Seite" => $seite,
                "FolioundSeite" => $folio . $seite,
            ]);

            // Create new page if necessary, save to have ID and attach images
            $manuskriptseite->save();

            $image = new ManuskriptseitenBild([
                "manuskriptseite" => $manuskriptseite->SeitenID,
                "Bildlink" => $downloadPath,
                "Bildlink_extern" => $this->baseLink,
                "Bildlinknachweis" => self::GALLICA_CITE,
                "webtauglich" => "nein"
            ]);

            $image->save();
        }
    }

    /**
     * Get the full image link from Gallica to download from
     * @param $pageNumber   Number of the page on Gallica
     * @return string   IIIF compliant link
     */
    public function getFullImageLink($pageNumber)
    {
        $iiifLink = str_replace(self::GALLICA_BASE, self::GALLICA_IIIF, $this->baseLink);

        $iiifLink = substr($iiifLink, 0, strrpos($iiifLink, "."));

        $iiifLink = explode("/f", $iiifLink)[0];

        $iiifLink .= "/f" . $pageNumber . "/full/full/0/native.jpg";

        return $iiifLink;
    }

    /**
     * Get target path where to put the download
     * @param int $pageNumber   Page number to download
     * @return string   Target download path
     */
    public function getDownloadPath($pageNumber)
    {
        $randomizer = str_random(8);
        if ($this->manuscriptId != null) {
            $title = preg_replace('/[.\s]/', "_", Manuskript::find($this->manuscriptId)->Kodextitel);
            $title = iconv('UTF-8', 'ASCII//TRANSLIT', $title);
            $title = preg_replace("/[^a-zA-Z0-9_]/", "", $title);

            $folio = $this->getGallicaPageMap()[$pageNumber]["Folio"];
            $seite = $this->getGallicaPageMap()[$pageNumber]["Seite"];
            $filename = "{$title}_f{$folio}{$seite}_{$randomizer}.jpg";

            return $title . "/" . $filename;
        }

        $gallicaId = explode("/", $this->getFullImageLink($pageNumber))[6];

        return "{$gallicaId}/{$gallicaId}_f{$pageNumber}_{$randomizer}.jpg";
    }


    /**
     * Check whether the current download instructions
     * possess a page range
     * @return bool
     */
    public function hasPageRange()
    {
        return (
            $this->manuscriptId &&
            $this->folioStart && $this->seiteStart &&
            $this->folioEnd && $this->seiteEnd
        );
    }

    /**
     * Get the range of pages on Gallica according
     * to the download instructions
     * @return array
     */
    public function getGallicaRange()
    {
        $range = [];

        for ($i = $this->gallicaStart; $i <= $this->gallicaEnd; $i++) {
            array_push($range, $i);
        }

        return $range;
    }

    /**
     * Create a map of folio/seite and Gallica page numbers
     * @return array
     * @throws \Doctrine\DBAL\Query\QueryException
     */
    public function getGallicaPageMap()
    {
        $gallicaRange = $this->getGallicaRange();

        if (!$this->hasPageRange()) {
            return $gallicaRange;
        }

        $pageRange = Manuskript::createPageRange(
            $this->folioStart,
            $this->seiteStart,
            $this->folioEnd,
            $this->seiteEnd
        );

        return array_combine($gallicaRange, $pageRange);
    }
}