<?php

namespace App\Models\Umwelttexte;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Umwelttexte\BelegstellenKategorie
 *
 * @property int $id
 * @property string $name
 * @property string $classification
 * @property int $supercategory
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Umwelttexte\Belegstelle[] $belegstellen
 * @property-read string $full_name
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenKategorie whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenKategorie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenKategorie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenKategorie whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenKategorie whereSupercategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BelegstellenKategorie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BelegstellenKategorie extends Model
{
    protected $table = "belegstellen_kategorie";

    public $incrementing = false;

    protected $guarded = [];

    /**
     * Get Umwelttexte for this category
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function belegstellen()
    {
        return $this->hasMany(Belegstelle::class, 'kategorie', 'id');
    }

    /**
     * Get readable name for the category, including id
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->id}: {$this->name}";
    }

    /**
     * Cast all items to an array for select boxes
     * @return array
     */
    public static function toSelectArray()
    {
        $selectArray = self::all()->pluck("fullName", "id")->toArray();
        $selectArray[""] = "Keine Kategorie";
        return $selectArray;
    }

}
