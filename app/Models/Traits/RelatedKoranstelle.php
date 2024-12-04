<?php

namespace App\Models\Traits;

use App\Models\Koranstelle;

/**
 * Trait RelatedKoranstelle
 * @package App\Models\Traits
 */
trait RelatedKoranstelle
{
    /**
     * Get Kairo Variant of for this text coordinate
     * @return mixed
     */
    public function getKairoVariantAttribute()
    {
        $koranstelle = Koranstelle::where([
            "sure" => $this->attributes["sure"],
            "vers" => $this->attributes["vers"],
            "wort" => $this->attributes["wort"]
        ])->first();

        return $koranstelle;
    }
}
