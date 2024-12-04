<?php

namespace App\Models;

use App\Models\Manuskripte\ManuskriptseitenBild;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ImageDetail
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $relation
 * @property string $relation_id
 * @property string $image_relation
 * @property string $image_id
 * @property string $title
 * @property string $description
 * @property float $x
 * @property float $y
 * @property float $width
 * @property float $height
 * @property int $lastUser
 * @property-read mixed $manuscript_iiif_image_detail
 * @property-read \App\Models\Manuskripte\ManuskriptseitenBild $manuscriptImage
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail variantReadingsWithMetadata($queryString)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereImageRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereLastUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereRelationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageDetail whereY($value)
 * @mixin \Eloquent
 */
class ImageDetail extends Model
{
    const RELATION_TYPE_MANUSCRIPT_VARIANT_READINGS = "manuskriptseiten_variant_readings";
    const RELATION_TYPE_MANUSCRIPT_VARIANTS_IN_ORTHOGRAPHY = "manuskriptseiten_variant_orthography";
    const RELATION_TYPE_MANUSCRIPT_VERSE_SEPARATORS = "manuskriptseiten_verse_separators";
    const RELATION_TYPE_CODEX_ILLUMINATION = "codex-illumination";
    const IMAGE_RELATION_TYPE_MANUSCRIPT = "manuskript";

    protected $table = "image_details";

    protected $guarded = ["id"];

    /**
     * Get the corresponding manuscript image for this image detail
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manuscriptImage()
    {
        return $this->belongsTo(ManuskriptseitenBild::class, 'image_id', 'id');
    }

    /**
     * Get the corresponding iiif compatible link of this annotation
     * @return mixed
     */
    public function getManuscriptIiifImageDetailAttribute()
    {
        $imageLink = $this->manuscriptImage->iiifImageRangeLink;

        $imageLink = str_replace(
            ["{x}", "{y}", "{width}", "{height}"],
            [$this->attributes["x"], $this->attributes["y"], $this->attributes["width"], $this->attributes["height"]],
            $imageLink
        );

        return $imageLink;
    }

    /**
     * Get entries which contain the query string in either the title or description field
     * @param $query
     * @param $queryString
     */
    public function scopeVariantReadingsWithMetadata($query, $queryString)
    {
        $query->where("relation", self::RELATION_TYPE_MANUSCRIPT_VARIANT_READINGS)
            ->where("title", "LIKE", "%{$queryString}%")
            ->orWhere("description", "LIKE", "%{$queryString}%");
    }
}
