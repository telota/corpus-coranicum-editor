<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Relations\Pivot;

class KommentarBelegstellen extends Pivot
{
    use CreatedUpdatedBy;
    protected $table = "kommentar_belegstelle";

}
