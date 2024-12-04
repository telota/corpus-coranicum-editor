<?php

namespace App\Models\Lesarten;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lesarten\Lesart
 *
 * @property int $id
 * @property int $leseart
 * @property int $wort
 * @property string $variante
 * @property int|null $alt_sure
 * @property int|null $alt_vers
 * @property int|null $alt_wort
 * @method static \Illuminate\Database\Eloquent\Builder|Lesart whereAltSure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesart whereAltVers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesart whereAltWort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesart whereLeseart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesart whereVariante($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesart whereWort($value)
 * @mixin \Eloquent
 */
class Lesart extends Model
{
    protected $table = "lc_variante";

    public $timestamps = false;
}
