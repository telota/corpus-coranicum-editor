<?php

namespace App\Models;

use App\Models\Helpers\IiifAnnotation;
use App\Models\Helpers\IiifCanvas;
use App\Models\Helpers\IiifThumbnail;
use App\Models\Manuskripte\ManuskriptseitenBild;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PermalinkImage
 *
 * @property int $id
 * @property string $reference
 * @property string $original_base_url
 * @property string $original_manuscript_page
 * @property string $original_manuscript_image
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $iiif_annotation
 * @property-read mixed $iiif_base_link
 * @property-read mixed $iiif_canvas
 * @property-read mixed $iiif_digilib_base_link
 * @property-read mixed $iiif_digilib_thumbnail_link
 * @property-read mixed $iiif_full_image_link
 * @property-read mixed $iiif_thumbnail
 * @property-read mixed $iiif_thumbnail_link
 * @property-read \App\Models\Manuskripte\ManuskriptseitenBild $manuscriptImage
 * @method static \Illuminate\Database\Eloquent\Builder|PermalinkImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermalinkImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermalinkImage whereOriginalBaseUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermalinkImage whereOriginalManuscriptImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermalinkImage whereOriginalManuscriptPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermalinkImage whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermalinkImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PermalinkImage extends Model
{
    protected $table = "permalink_images";
    protected $primaryKey = "reference";

    /**
     * Eloquent relation
     * Get manuscript image for this permalink image
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manuscriptImage()
    {
        return $this->belongsTo(ManuskriptseitenBild::class, 'original_manuscript_image', 'id');
    }

    /**
     * Produce IIIF compliant link to digilib
     * @return mixed
     */
    public function getIiifFullImageLinkAttribute()
    {
        $imageLink = $this->manuscriptImage->iiifFullImageLink;

        return $imageLink;
    }

    /**
     * Get the IIIF base for this image for further calculations or IIIF manifest generation
     * @return mixed
     */
    public function getIiifBaseLinkAttribute()
    {
        $baseLink = $this->manuscriptImage->iiifBaseLink;

        return $baseLink;
    }

    /**
     * Generate the IIIF digilib base link for this image
     * @return mixed
     */
    public function getIiifDigilibBaseLinkAttribute()
    {
        $digilibLink = $this->manuscriptImage->iiifBaseLink;

        return $digilibLink;
    }

    /**
     * Get the IIIF thumbnail URL for this image, e.g. for showing in IIIF viewers
     * @return mixed
     */
    public function getIiifDigilibThumbnailLinkAttribute()
    {
        $digilibLink = $this->manuscriptImage->iiifThumbnailLink;

        return $digilibLink;
    }

    /**
     * Get the IIIF thumbnail URL for this image, e.g. for showing in IIIF viewers
     * @return mixed
     */
    public function getIiifThumbnailLinkAttribute()
    {
        $thumbnailLink = $this->manuscriptImage->iiifThumbnailLink;

        return $thumbnailLink;
    }

    /**
     * Generate the canvas IIIF-JSON-LD content for this manuscript image
     * @return array
     */
    public function getIiifAnnotationAttribute()
    {
        $annotation = new IiifAnnotation($this->attributes["reference"], $this->iiifDigilibBaseLink);

        //$annotation->iiifBaseLink = $this->iiifDigilibBaseLink;

        return $annotation->generateContent();
    }

    /**
     * Generate the IIIF canvas for this image
     * @return array
     */
    public function getIiifCanvasAttribute()
    {
        $label = $this->manuscriptImage->readableLabel;

        $canvas = new IiifCanvas(
            $this->attributes["reference"],
            $this->iiifDigilibBaseLink,
            $label
        );

        //$canvas->iiifBaseLink = $this->iiifDigilibBaseLink;

        return $canvas->generateContent();
    }

    /**
     * Generate the IIIF thumbnail object
     * @return array
     */
    public function getIiifThumbnailAttribute()
    {
        $thumbnail = new IiifThumbnail($this->attributes["reference"]);

        $thumbnail->iiifThumbnailLink = $this->iiifDigilibThumbnailLink;

        $thumbnail->iiifBaseLink = $this->iiifDigilibBaseLink;

        return $thumbnail->generateContent();
    }
}
