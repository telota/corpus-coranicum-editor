<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Validation\Rule;

class Attribution extends Model
{
    use CreatedUpdatedBy;

    protected $table = "ms_attributed_to";

    protected $guarded = [
        "id"
    ];

    public $timestamps = true;
    public function formFields($id = null)
    {
        $unique = Rule::unique(self::class, 'person');
        if ($id) {
            $unique->ignore($id);
        }
        return [
            "person" => ["required", $unique],
        ];
    }
    public function manuscripts() : BelongsToMany
    {
        return $this->belongsToMany(
            ManuscriptNew::class,
            ManuscriptAttributedTo::class,
            'attributed_to_id',
            'manuscript_id',
        );
    }
}
