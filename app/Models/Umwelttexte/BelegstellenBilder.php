<?php

namespace App\Models\Umwelttexte;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Umwelttexte\BelegstellenBilder
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $belegstelle
 * @property string $bildlink
 * @property string $bildnachweis
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBilder whereBelegstelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBilder whereBildlink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBilder whereBildnachweis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBilder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBilder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenBilder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BelegstellenBilder extends Model
{
    public $table = "belegstellen_bilder";
}
