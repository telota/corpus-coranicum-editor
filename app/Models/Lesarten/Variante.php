<?php

namespace App\Models\Lesarten;

use App\Models\Koranstelle;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Variante
 * @package App\Models\Lesarten
 */
class Variante extends Model
{
    protected $table = "lc_variante";

    protected $guarded = ["id"];

    public $timestamps = false;

    /**
     * Get reading (leseart) object for this variant.
     *
     * Notice: vleseart because "leseart" is already a property of
     * the lc_variants table.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vleseart()
    {
        return $this->hasOne(Leseart::class, 'id', 'leseart');
    }

    /**
     * Get text coordinate for this variant
     * @return mixed
     */
    public function koranstelle()
    {
        return $this->hasOne(Koranstelle::class, "wort", "wort")
            ->where("sure", $this->vleseart->sure)
            ->where("vers", $this->vleseart->vers);
    }

    /**
     * Get all variants by the specified word
     * @param $word
     * @return
     */
    public static function getVariantsByWord($word)
    {
        return Variante::where("variante", $word)->get();
    }
}
