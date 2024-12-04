<?php

namespace App\Models;

use App\Models\Umwelttexte\Belegstelle;
use Illuminate\Database\Eloquent\Model;

class Kommentar extends Model
{
    protected $table = "kommentar";

    protected $primaryKey = "sure";

    protected $guarded = [];

    public function intertextsMentioned()
    {
        return $this->belongsToMany(Belegstelle::class,
            'kommentar_belegstelle',
            'sure',
            'belegstelle_id')
            ->using(KommentarBelegstellen::class);
    }

}
