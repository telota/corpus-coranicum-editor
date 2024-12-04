<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Validation\Rule;

class Provenance extends Model
{
    use CreatedUpdatedBy;
    protected $table = "ms_provenances";

    protected $guarded = [
        "id"
    ];

    public $timestamps = true;
    public function formFields($id = null)
    {
        $unique = Rule::unique(self::class, 'provenance');
        if ($id) {
            $unique->ignore($id);
        }
        return [
            "provenance" => ["required", $unique],
        ];
    }

    public function manuscripts() : BelongsToMany
    {
        return $this->belongsToMany(
            ManuscriptNew::class,
            'ms_manuscript_provenances',
            'provenance_id',
            'manuscript_id',
        );
    }

}
