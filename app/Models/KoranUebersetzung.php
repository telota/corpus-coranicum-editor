<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\KoranUebersetzung
 *
 * @property int $id
 * @property string $sprache
 * @property string $sure_vers
 * @property string $text
 * @property int|null $sure
 * @property int|null $vers
 * @method static \Illuminate\Database\Eloquent\Builder|KoranUebersetzung whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KoranUebersetzung whereSprache($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KoranUebersetzung whereSure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KoranUebersetzung whereSureVers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KoranUebersetzung whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KoranUebersetzung whereVers($value)
 * @mixin \Eloquent
 */
class KoranUebersetzung extends Model
{
    protected $table = "koran_uebersetzung";

    public $timestamps = false;

//    protected $primaryKey = "index";

    protected $guarded = ["id"];
}
