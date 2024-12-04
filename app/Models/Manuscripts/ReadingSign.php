<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class ReadingSign extends Model
{
    use CreatedUpdatedBy;
    protected $table = "ms_reading_signs";

    protected $guarded = [
        "id"
    ];

    public $timestamps = true;
    public function formFields($id = null)
    {
        $unique = Rule::unique(self::class, 'reading_sign');
        if ($id) {
            $unique->ignore($id);
        }
        return [
            "reading_sign" => ["required", $unique],
        ];
    }

    public function manuscripts()
    {
        return $this->belongsToMany(
            ManuscriptNew::class,
            'ms_manuscript_reading_signs',
            'reading_sign_id',
            'manuscript_id',
        );
    }

}
