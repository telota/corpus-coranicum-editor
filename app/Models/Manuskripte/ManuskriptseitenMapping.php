<?php

namespace App\Models\Manuskripte;

use App\Models\Koranstelle;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Routing\Tests\Loader\AnnotationDirectoryLoaderTest;

/**
 * App\Models\Manuskripte\ManuskriptseitenMapping
 *
 * @property int $id
 * @property int $manuskriptseite
 * @property int $sure_start
 * @property int $vers_start
 * @property int $wort_start
 * @property int $sure_ende
 * @property int $vers_ende
 * @property int $wort_ende
 * @property-read mixed $koranstellen
 * @property-read mixed $readable_coordinates
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenMapping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenMapping whereManuskriptseite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenMapping whereSureEnde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenMapping whereSureStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenMapping whereVersEnde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenMapping whereVersStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenMapping whereWortEnde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenMapping whereWortStart($value)
 * @mixin \Eloquent
 */
class ManuskriptseitenMapping extends Model
{
    protected $table = "manuskriptseiten_mapping";

    public $timestamps = false;

    /**
     * Check whether two mappings are overlapping.
     * @param ManuskriptMapping $compMapping
     * @return bool
     */
    public function inRange(ManuskriptseitenMapping $compMapping)
    {
        // If both starting suras are equal, check whether the starting vers of the next mapping is
        // at least higher than the one before.
        if (
            $compMapping->sure_start == $this->attributes["sure_start"] &&
            $compMapping->vers_start >= $this->attributes["vers_start"] &&
            $compMapping->vers_start <= $this->attributes["vers_ende"]
        ) {
            return true;
        } elseif (
            // If the starting sura of the next mapping is equal to the ending sura of the current one,
            // check whether the starting verse is also lower.
            $compMapping->sure_start == $this->attributes["sure_ende"] &&
            $compMapping->vers_start <= $this->attributes["vers_ende"]
        ) {
            return true;
        } elseif (
            // Check whether the starting sura of the next mapping is in range of the current one.
            $compMapping->sure_start > $this->attributes["sure_start"] &&
            $compMapping->sure_start < $this->attributes["sure_ende"]
        ) {
            return true;
        } elseif (
            $this->toKoranstelleEnde()->isNextOrEqualVerse($compMapping->sure_start, $compMapping->vers_start) ||
            $compMapping->toKoranstelleEnde()->isNextOrEqualVerse(
                $this->attributes["sure_start"],
                $this->attributes["vers_start"]
            )
        ) {
            return true;
        }

        // If none of the conditions were matched, return false.
        return false;
    }

    /**
     * Convert mapping to Koranstelle (start)
     *
     */
    public function toKoranstelleStart()
    {
        $koranstelle = new Koranstelle();

        $koranstelle->sure = $this->attributes["sure_start"];
        $koranstelle->vers = $this->attributes["vers_start"];

        return $koranstelle;
    }

    /**
     * Convert mapping to Koranstelle (ending)
     * @return Koranstelle
     */
    public function toKoranstelleEnde()
    {
        $koranstelle = new Koranstelle();

        $koranstelle->sure = $this->attributes["sure_ende"];
        $koranstelle->vers = $this->attributes["vers_ende"];

        return $koranstelle;
    }

    /**
     * Parse start text coordinate to string
     * @return string
     */
    public function startMappingToCoordinate()
    {
        return
            str_pad($this->attributes["sure_start"], 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->attributes["vers_start"], 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->attributes["wort_start"], 3, 0, STR_PAD_LEFT);
    }

    /**
     * Parse end text coordinate to string
     * @return string
     */
    public function endMappingToCoordinate()
    {
        return
            str_pad($this->attributes["sure_ende"], 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->attributes["vers_ende"], 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->attributes["wort_ende"], 3, 0, STR_PAD_LEFT);
    }

    /**
     * Parse text coordinate to readable string, e.g. 001:001:001-001:003:001
     * @return string
     */
    public function getReadableCoordinatesAttribute()
    {
        return $this->startMappingToCoordinate() . "-" . $this->endMappingToCoordinate();
    }

    /**
     * Get all Koranstellen for this mapping
     * @return \Illuminate\Support\Collection
     */
    public function getKoranstellenAttribute()
    {
        return Koranstelle::getWordsWithinRange(
            $this->attributes["sure_start"],
            $this->attributes["vers_start"],
            $this->attributes["wort_start"],
            $this->attributes["sure_ende"],
            $this->attributes["vers_ende"],
            $this->attributes["wort_ende"]
        );
    }

    /**
     * Create new page mappings for a given text coordinate range and page id
     * @param $coordinateRange
     * @param $seitenId
     * @return ManuskriptseitenMapping|bool
     */
    public static function newMappingFromCoordinateRange($coordinateRange, $seitenId)
    {
        if (empty($coordinateRange)) {
            return false;
        }

        $ranges = explode("-", $coordinateRange);

        $startRange = $ranges[0];
        $endRange = $ranges[1];

        $start = Koranstelle::getKoranstelleFromCoordinate($startRange);
        $end = Koranstelle::getKoranstelleFromCoordinate($endRange);


        if (!($start) || !($end)) {
            echo $coordinateRange . "\n";
            //return new ManuskriptseitenMapping();
        }


        $mapping = new ManuskriptseitenMapping();

        $mapping->manuskriptseite = $seitenId;
        $mapping->sure_start = $start->sure;
        $mapping->vers_start = $start->vers;
        $mapping->wort_start = $start->wort;

        $mapping->sure_ende = $end->sure;
        $mapping->vers_ende = $end->vers;
        $mapping->wort_ende = $end->wort;

        return $mapping;
    }
}
