<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Validation\Rule;

class Funder extends Model
{
    use CreatedUpdatedBy;

    protected $table = "ms_funders";

    protected $guarded = ["id"];

    public $timestamps = true;

    public function formFields($id = null)
    {
        $unique = Rule::unique(self::class, 'funder');
        if ($id) {
            $unique->ignore($id);
        }
        return [
            "funder" => ["required", $unique],
        ];
    }

    public function manuscripts(): BelongsToMany
    {
        return $this->belongsToMany(
            ManuscriptNew::class,
            'ms_manuscript_funders',
            'funder_id',
            'manuscript_id',
        );
    }

}
