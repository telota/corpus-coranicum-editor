<?php

namespace App\Models\Umwelttexte;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Umwelttexte\BelegstellenBearbeiter
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $belegstelle
 * @property string $bearbeiter
 * @property string $zusatz
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBearbeiter whereBearbeiter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBearbeiter whereBelegstelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBearbeiter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBearbeiter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBearbeiter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBearbeiter whereZusatz($value)
 * @mixin \Eloquent
 */
class BelegstellenBearbeiter extends Model
{
    protected $table = "belegstellen_bearbeiter";

    protected $fillable = ["belegstelle", "bearbeiter"];
}
