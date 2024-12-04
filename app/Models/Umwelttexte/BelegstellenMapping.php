<?php

namespace App\Models\Umwelttexte;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Umwelttexte\BelegstellenMapping
 *
 * @property int $id
 * @property int $belegstelle
 * @property int $sure_start
 * @property int $vers_start
 * @property int $sure_ende
 * @property int $vers_ende
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenMapping whereBelegstelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenMapping whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenMapping whereSureEnde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenMapping whereSureStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenMapping whereVersEnde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenMapping whereVersStart($value)
 * @mixin \Eloquent
 */
class BelegstellenMapping extends Model
{
    protected $table = "belegstellen_mapping";

    public $timestamps = false;

    /**
     * Get readable text coordinate.
     * TODO: Use trait
     * @return string
     */
    public function readableTextstelle()
    {
        if ($this->sure_start == $this->sure_ende && $this->vers_start == $this->vers_ende) {
            return str_pad($this->sure_start, 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($this->vers_start, 3, 0, STR_PAD_LEFT);
        } else {
            return str_pad($this->sure_start, 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($this->vers_start, 3, 0, STR_PAD_LEFT) . "-" .
                str_pad($this->sure_ende, 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($this->vers_ende, 3, 0, STR_PAD_LEFT);
        }
    }
}
