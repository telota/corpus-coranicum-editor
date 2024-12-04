<?php

namespace App\Models\Traits;

/**
 * Trait ReadableKoranstellen
 * @package App\Models\Traits
 */
trait ReadableKoranstellen
{

    /**
     * Get a readable Koranstelle for
     */
    public function getReadableKoranstelleAttribute()
    {
        return
            str_pad($this->sure, 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->vers, 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->wort, 3, 0, STR_PAD_LEFT);

    }

    /**
     * Get text coordinate as a string with German labels
     * @return string
     */
    public function getGermanKoranstelleAttribute()
    {
        return "Sure {$this->sure}, Vers {$this->vers}, Wort {$this->wort}";
    }
}
