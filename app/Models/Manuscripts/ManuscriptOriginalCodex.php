<?php

namespace App\Models\Manuscripts;

use Illuminate\Database\Eloquent\Model;

class ManuscriptOriginalCodex extends Model
{
    protected $table = "ms_original_codexes";

    protected $primaryKey = "id";

    public $incrementing = false;
    public $timestamps = true;

    protected $guarded = [];

    /**
     * Attributes that should not be shown in the editing view
     *
     * @return array
     */
    public $editIgnore =
        array(
            "updated_at",
            "created_at",
            "updated_by",
            "created_by"
        );

    /**
     * Get Manuscripts for this category
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function manuscripts()
    {
        return $this->hasMany(ManuscriptNew::class, 'original_codex_id', 'id');
    }

    /**
     * Get Script Style for this category
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function scriptStyle()
    {
        return $this->hasOne(ScriptStyle::class,  'id', 'script_style_id' );
    }

    /**
     * Get readable name for the category, including id
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->id}: {$this->original_codex_name}";
    }

    /**
     * Cast all items to an array for select boxes
     * @return array
     */
    public static function toSelectArray()
    {
        $selectArray = self::all()->pluck("fullName", "id")->toArray();
        return $selectArray;
    }

}
