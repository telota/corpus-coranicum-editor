<?php

namespace App\Models\Manuscripts;

use App\Models\Translation;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Place extends Model
{
    use CreatedUpdatedBy;

    protected $table = "ms_places";


    protected $guarded = [
        "id"
    ];

    public function formFields()
    {
        return [
            "place" => "required",
            "place_name" => "required",
            "country_code" => "required",
            "description_id" => [],
            "link" => [],
            "image_link" => [],
            "image_original_link" => [],
            "image_description" => [],
            "longitude" => [],
            "latitude" => [],
            "geonames" => [],
        ];
    }

    public
        $timestamps = true;

    public
    function manuscripts()
    {
        return $this->hasMany(ManuscriptNew::class, 'place_id');
    }

    public
    function description(): BelongsTo
    {
        return $this->belongsTo(Translation::class, 'description_id', 'id');
    }

    public
    static function getReadableName($id)
    {
        // If id is empty, no Place has been selected
        if (empty($id)) {
            return "";
        }

        $place = Place::find($id);

        $placeFull = $place->place_name . " (" . $place->place . ", " . $place->country_code . ")";

        return $placeFull;
    }

}
