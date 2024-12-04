<?php

namespace App\Models\Lesarten;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lesarten\Leser
 *
 * @property int $id
 * @property string $name
 * @property string $anzeigename
 * @property string $sigle
 * @property string $abkuerzung
 * @property string|null $kommentar
 * @property string $ort
 * @property string $biografie
 * @property string $namekomplett
 * @property string $todesdatum
 * @property string $todesdatum_AH
 * @property string $ueberlieferer
 * @property string $ueberlieferertyp
 * @property int $kanonisch
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lesarten\LeserAlias[] $aliases
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lesarten\LeseartLeser[] $mappings
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereAbkuerzung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereAnzeigename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereBiografie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereKanonisch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereKommentar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereNamekomplett($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereOrt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereSigle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereTodesdatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereTodesdatumAH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereUeberlieferer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Leser whereUeberlieferertyp($value)
 * @mixin \Eloquent
 */
class Leser extends Model
{
    protected $table = "lc_leser";

    public $timestamps = false;

    public $editIgnore = array(
        "id",
        "abkuerzung"
    );

    public $editLarge = array(
        "kommentar"
    );

    public $editAlter = array(
        "alias",
        "kanonisch",
    );

    public static $notNullStrings = ["abkuerzung",
        "ort",
        "biografie",
        "namekomplett",
        "todesdatum",
        "todesdatum_AH",
        "ueberlieferer",
        "ueberlieferertyp"];

    /**
     * Get variant readings by this reader
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mappings()
    {
        return $this->hasMany(LeseartLeser::class, 'leser', 'id');
    }

    /**
     * Get other names of this reader
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aliases()
    {
        return $this->hasMany(LeserAlias::class, 'leser', 'id');
    }

    /**
     * Get all Leser as an associative array to populate a select dropdown
     * id => anzeigename
     */
    public static function getAllSelect()
    {
        $selectLeser = array();

        $leser = Leser::all();

        foreach ($leser as $l) {
            $selectLeser[$l->id] = $l->sigle . " - " . $l->name;
        }

        natcasesort($selectLeser);

        return $selectLeser;
    }
}
