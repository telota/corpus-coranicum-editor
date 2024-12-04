<?php

namespace App\Models\Lesarten;

use Illuminate\Database\Eloquent\Model;

class Leseart extends Model
{
    protected $table = "lc_leseart";

    public $timestamps = false;

    public function quelle()
    {
        return $this->belongsTo(Quelle::class, 'quelle_id', 'id');
    }

    public function leser()
    {
        return $this->belongsToMany(
            Leser::class,
            LeseartLeser::class,
            'leseart',
            'leser'
        );
    }
    /**
     * Get all variants readings in their transliterated form
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function varianten()
    {
        return $this->hasMany(Variante::class, 'leseart', 'id');
    }

    /**
     * Get a variant reading in its transliterated form by a word coordinate within a verse
     * @param int $word
     * @return mixed
     */
    public function variantenWort($word = 0)
    {
        return $this->hasOne(Variante::class, 'leseart', 'id')
            ->where('wort', $word)
            ->first();
    }

}
