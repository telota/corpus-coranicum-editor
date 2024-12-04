<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Validation\Rule;

//TODO: Not sure this is correct
class AntiquityMarket extends Model
{
    use CreatedUpdatedBy;

    protected $table = "ms_antiquity_markets";

    protected $guarded = [
        "id"
    ];

    public $timestamps = true;

    public function formFields($id = null)
    {
        $unique = Rule::unique(self::class, 'antiquity_market');
        if ($id) {
            $unique->ignore($id);
        }
        return [
            "antiquity" => ["required", $unique],
        ];
    }

    public function manuscripts() : BelongsToMany
    {
        return $this->belongsToMany(
            ManuscriptNew::class,
            'ms_manuscript_antiquity_markets',
            'antiquity_market_id',
            'manuscript_id',
        );
    }
}
