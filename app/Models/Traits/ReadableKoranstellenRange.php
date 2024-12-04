<?php

namespace App\Models\Traits;

/**
 * Trait ReadableKoranstellen
 * @package App\Models\Traits
 */
trait ReadableKoranstellenRange
{

    public function getReadableStartCoordinate()
    {
        return
            str_pad($this->sure_start, 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->vers_start, 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->wort_start, 3, 0, STR_PAD_LEFT);
    }

    public function getReadableEndCoordinate()
    {
        return
            str_pad($this->sure_ende, 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->vers_ende, 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->wort_ende, 3, 0, STR_PAD_LEFT);
    }


    /**
     * Get a readable Koranstelle for
     */
    public function getReadableKoranstelleAttribute()
    {
        return $this->getReadableStartCoordinate() . "-" . $this->getReadableEndCoordinate();
    }

    /**
     * Get text coordinate as a string with German labels
     * @return string
     */
    public function getGermanKoranstelleAttribute()
    {
        return "Sure {$this->sure_start}, Vers {$this->vers_start}, Wort {$this->wort_start} bis" .
            "Sure {$this->sure_ende}, Vers {$this->vers_ende}, Wort {$this->wort_ende}";
    }
}
