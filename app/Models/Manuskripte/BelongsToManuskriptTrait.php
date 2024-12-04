<?php


namespace App\Models\Manuskripte;


trait BelongsToManuskriptTrait
{
    public function manuskript()
    {
        return $this->belongsTo(Manuskript::class, "manuskript_id", "id");
    }
}
