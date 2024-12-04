<?php

namespace App\Models\Lesarten;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LeseartLeser extends Pivot
{
    use CreatedUpdatedBy;
    protected $table = 'lc_leseart_leser';

    public $timestamps = false;

    protected $guarded = ["id"];

    /**
     * Get variant reading record associated to this mapping record
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lesearten()
    {
        return $this->hasMany(Leseart::class, 'id', 'leseart');
    }

    /**
     * Get reader record associated to this mapping record
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lesers()
    {
        return $this->hasOne(Leser::class, 'id', 'leser');
    }
}
