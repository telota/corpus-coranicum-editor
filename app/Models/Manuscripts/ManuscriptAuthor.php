<?php

namespace App\Models\Manuscripts;

use App\Models\Manuskripte\BelongsToManuskriptTrait;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ManuscriptAuthor extends Pivot
{
    use CreatedUpdatedBy;
    protected $table = "ms_manuscript_author_roles";

    protected $guarded = ["id"];

    public $timestamps = true;


    /**
     * Get associated manuscript
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function manuscript()
    {
        return $this->hasOne(ManuscriptNew::class, "id", "manuscript_id");
    }
}
