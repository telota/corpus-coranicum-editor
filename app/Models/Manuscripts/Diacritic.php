<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Validation\Rule;

class Diacritic extends Model
{
    use CreatedUpdatedBy;

    protected $table = "ms_diacritics";

    protected $guarded = [ "id" ];

    public $timestamps = true;
    public function formFields($id = null)
    {
        $unique = Rule::unique(self::class, 'diacritic');
        if ($id) {
            $unique->ignore($id);
        }
        return [
            "diacritic" => ["required", $unique],
        ];
    }

    public function manuscripts() : BelongsToMany
    {
        return $this->belongsToMany(
            ManuscriptNew::class,
            'ms_manuscript_diacritics',
            'diacritic_id',
            'manuscript_id',
        );
    }

}
