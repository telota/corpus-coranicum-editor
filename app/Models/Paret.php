<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Paret
 *
 * @property int $id
 * @property string $sprache
 * @property string $sure_vers
 * @property string $text
 * @property int|null $sure
 * @property int|null $vers
 * @method static \Illuminate\Database\Eloquent\Builder|Paret getSure($sure)
 * @method static \Illuminate\Database\Eloquent\Builder|Paret whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paret whereSprache($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paret whereSure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paret whereSureVers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paret whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Paret whereVers($value)
 * @mixin \Eloquent
 */
class Paret extends Model
{
    protected $table = "koran_uebersetzung";

    public $timestamps = false;

    /**
     * Attributes that should be edited in a big text editor
     *
     * @return array
     */
    public $editLarge =
        array(
            "text"
        );

    /**
     * Attributes that need an alternate editing view
     *
     * @return array
     */
    public $editAlter = array(
        ""
    );

    public $editIgnore = array(
        "id",
        "sprache",
        "sure_vers",
        "sure",
        "vers"
    );

    /**
     * Get all paret translation within a given sura
     * @param $query
     * @param $sure
     * @return mixed
     */
    public function scopeGetSure($query, $sure)
    {
        return $query->where("sure", $sure)->get();
    }

}
