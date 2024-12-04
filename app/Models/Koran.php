<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Koran
 *
 * @property int $id
 * @property string $koranstelle
 * @property string $Bild
 * @property string $praefix
 * @property int $sure
 * @property int $vers
 * @property string|null $surenname
 * @property string $kommentar
 * @method static \Illuminate\Database\Eloquent\Builder|Koran whereBild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Koran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Koran whereKommentar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Koran whereKoranstelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Koran wherePraefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Koran whereSure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Koran whereSurenname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Koran whereVers($value)
 * @mixin \Eloquent
 */
class Koran extends Model
{
    protected $table = "koran";

    public $timestamps = false;

    public $fillable = [
        "kommentar"
    ];

    /**
     * Get the commentary for a reading
     * @param $sure
     * @param $vers
     * @param bool $check
     * @return bool
     */
    public static function getLeseartenKommentar($sure, $vers, $check = false)
    {
        $kommentar = Koran::where("sure", $sure)
            ->where("vers", $vers)
            ->first()
            ->kommentar;

        if ($check) {
            if (empty($kommentar)) {
                return false;
            }
            return true;
        }

        return $kommentar;
    }
}
