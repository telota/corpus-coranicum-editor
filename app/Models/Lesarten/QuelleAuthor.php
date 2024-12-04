<?php

namespace App\Models\Lesarten;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class QuelleAuthor extends Pivot
{
    use CreatedUpdatedBy;
    protected $table = 'lc_quelle_author_roles';
}
