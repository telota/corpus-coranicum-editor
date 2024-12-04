<?php

namespace App\Models\Manuskripte;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Manuskripte\ManuskriptMapping
 *
 * @property int $id
 * @property int $manuskript
 * @property int $sure_start
 * @property int $vers_start
 * @property int $wort_start
 * @property int $sure_ende
 * @property int $vers_ende
 * @property int $wort_ende
 * @property-read mixed $readable_coordinates
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptMapping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptMapping whereManuskript($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptMapping whereSureEnde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptMapping whereSureStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptMapping whereVersEnde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptMapping whereVersStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptMapping whereWortEnde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptMapping whereWortStart($value)
 * @mixin \Eloquent
 */
class ManuskriptMapping extends Model
{
    protected $table = "manuskript_mapping";

    protected $guarded = [
        "id"
    ];

    protected $fillable =  [
        "manuskript",
        "sure_start", "vers_start", "wort_start",
        "sure_ende", "vers_ende", "wort_ende"
    ];

    public $timestamps = false;


    /**
     * Parse start mapping coordinate to string
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
     * Parse end mapping coordinate to string
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
     * Convert a ManuskriptMapping object into a
     * ManuskriptseitenMapping object.
     */
    public function toManuskriptseitenMapping()
    {
        $mapping = new ManuskriptseitenMapping();

        $mapping->sure_start = $this->attributes["sure_start"];
        $mapping->vers_start = $this->attributes["vers_start"];
        $mapping->sure_ende = $this->attributes["sure_ende"];
        $mapping->vers_ende = $this->attributes["vers_ende"];

        return $mapping;
    }

    /**
     * Parse coordinate record to readable string, e.g. 001:001:001-001:003:001
     * @return string
     */
    public function getReadableCoordinatesAttribute()
    {
        return $this->startMappingToCoordinate() . "-" . $this->endMappingToCoordinate();
    }

    /**
     * @param $compMapping
     */
    public function overlapExtend($compMapping)
    {

        // If both starting suras are equal, take the lower verse.
        if ($compMapping->sure_start == $this->attributes["sure_start"]) {
            $this->attributes["vers_start"] = min(
                array($compMapping->vers_start, $this->attributes["vers_start"])
            );
        } elseif ($compMapping->sure_start < $this->attributes["sure_start"]) {
            // If the compared mapping starts lower, take thoses values
            $this->attributes["sure_start"] = $compMapping->sure_start;
            $this->attributes["vers_start"] = $compMapping->vers_start;
        }

        // If the current values are lower, don't do anything

        // If both ending suras are equal, take the higher verse value.
        if ($compMapping->sure_ende == $this->attributes["sure_ende"]) {
            $this->attributes["vers_ende"] = max(
                array($compMapping->vers_ende, $this->attributes["vers_ende"])
            );
        } elseif ($compMapping->sure_ende > $this->attributes["sure_ende"]) {
            // If the compared mapping ends higher, take thoses values
            $this->attributes["sure_ende"] = $compMapping->sure_ende;
            $this->attributes["vers_ende"] = $compMapping->vers_ende;
        }
    }
}
