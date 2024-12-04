<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class ScriptStyle extends Model
{
    use CreatedUpdatedBy;

    protected $table = "ms_script_styles";

    protected $guarded = [
        "id"
    ];

    public $timestamps = true;

    public function formFields($id = null)
    {
        $unique = Rule::unique(self::class, 'style');
        if ($id) {
            $unique->ignore($id);
        }
        return [
            "style" => ["required", $unique],
        ];
    }

    public function manuscripts()
    {
        return $this->belongsToMany(
            ManuscriptNew::class,
            'ms_manuscript_script_styles',
            'style_id',
            'manuscript_id',
        );
    }
}
