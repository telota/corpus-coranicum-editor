<?php

namespace App\Models\Manuskripte;

use App\Models\Helpers\IiifCanvas;
use App\Models\ImageDetail;
use App\Models\PermalinkImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * App\Models\Manuskripte\ManuskriptseitenBild
 *
 * @property int $id
 * @property int $manuskriptseite
 * @property string $Bildlink
 * @property string $Bildlink_extern
 * @property string $Bildlinknachweis
 * @property string $webtauglich
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ImageDetail[] $detailViews
 * @property-read string $full_path
 * @property-read mixed $greyskin_path
 * @property-read string $iiif_base_link
 * @property-read mixed $iiif_canvas
 * @property-read mixed $iiif_full_image_link
 * @property-read mixed $iiif_image_range_link
 * @property-read mixed $iiif_link_set
 * @property-read mixed $iiif_modal_link
 * @property-read mixed $iiif_thumbnail
 * @property-read mixed $iiif_thumbnail_link
 * @property-read mixed $modal_path
 * @property-read mixed $pid
 * @property-read string $scaler_path
 * @property-read \App\Models\PermalinkImage $persistentIdentifier
 * @property-read \App\Models\Manuskripte\Manuskriptseite $seite
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenBild whereBildlink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenBild whereBildlinkExtern($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenBild whereBildlinknachweis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenBild whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenBild whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenBild whereManuskriptseite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenBild whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManuskriptseitenBild whereWebtauglich($value)
 * @mixin \Eloquent
 */
class ManuskriptseitenBild extends Model
{

    public $table = "manuskriptseiten_bilder";

    protected $guarded = ["id"];

    /**
     * Get parent manuscript page record of this image
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seite()
    {
        return $this->belongsTo(Manuskriptseite::class, 'manuskriptseite', 'SeitenID');
    }

    public function getReadableLabelAttribute()
    {
        return $this->seite->readableLabel;
    }

    /**
     * Get persistend identifier record of this image
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function persistentIdentifier()
    {
        return $this->hasOne(PermalinkImage::class, 'original_manuscript_image', 'id');
    }

    /**
     * Get image annotations / detail views for this image, if any exist
     * @return mixed
     */
    public function detailViews()
    {
        return $this->hasMany(ImageDetail::class, 'image_id', 'id')
            ->where('image_relation', 'manuscript_image');
    }

    public function getPidAttribute()
    {
        return $this->persistentIdentifier->reference;
    }

    /**
     * Get link to full image on digilib
     * @return string
     */
    public function getFullPathAttribute()
    {
        return ManuskriptseitenBild . phpConfig::get("constants.digilib.full") . $this->Bildlink;
    }

    /**
     * Get Iiif compatibale scaler base link
     * @return string
     */
    public function getIiifBaseLinkAttribute()
    {
        $bildlink = $this->Bildlink;

        if ($this->webtauglich != "ja") {
            $bildlink = Config::get("constants.digilib.iiif.fallback.no_rights");
        }

        $imageLink =
            ManuskriptseitenBild . phpConfig::get("constants.digilib.iiif.scaler") .
            str_replace("/", "!", $bildlink);

        return $imageLink;
    }

    public static function getFallbackBaseLink()
    {
        $bildlink = Config::get("constants.digilib.iiif.fallback.no_rights");
        $imageLink =
            ManuskriptseitenBild . phpConfig::get("constants.digilib.iiif.scaler") .
            str_replace("/", "!", $bildlink);

        return $imageLink;
    }

    /**
     * Get Iiif compatible scaler link (full resolution)
     */
    public function getIiifFullImageLinkAttribute()
    {
        $imageLink =
            $this->getIiifBaseLinkAttribute() .
            Config::get("constants.digilib.iiif.size.full");

        return $imageLink;
    }

    /**
     * Return a IIIF link to this image, resized for the cropping module
     * @return string
     */
    public function getIiifImageRangeLinkAttribute()
    {
        $imageLink =
            $this->getIiifBaseLinkAttribute() .
            Config::get("constants.digilib.iiif.size.crop");

        return $imageLink;
    }

    /**
     * Get a IIIF link to this image, resized for display in modals
     * @return string
     */
    public function getIiifModalLinkAttribute()
    {
        $imageLink =
            $this->getIiifBaseLinkAttribute() .
            Config::get("constants.digilib.iiif.size.modal");

        return $imageLink;
    }

    /**
     * Get a IIIF link set to this image, including full resolution, range resolution and modal resolutions
     * @return array
     */
    public function getIiifLinkSetAttribute()
    {
        return [
            "full" => $this->iiifFullImageLink,
            "range" => $this->IiifImageRangeLink,
            "modal" => $this->iiifModalLink
        ];
    }

    /**
     * Get link to scaler image on digilib
     * @param int $width
     * @return string
     */
    public function getScalerPathAttribute()
    {
        $width = 750;

        return ManuskriptseitenBild . phpConfig::get('constants.digilib.scaler') . $this->Bildlink . "&dw=" . $width;
    }

    /**
     * Get a non-IIIF link to the image, resized for display in modals
     * @return string
     */
    public function getModalPathAttribute()
    {
        $width = 550;

        return ManuskriptseitenBild . phpConfig::get('constants.digilib.scaler') . $this->Bildlink . "&dw=" . $width;
    }

    /**
     * Get full resolution image link, for display in the Digilib Greyskin application
     * @return string
     */
    public function getGreyskinPathAttribute()
    {
        return ManuskriptseitenBild . phpConfig::get('constants.digilib.full') . $this->Bildlink;
    }

    /**
     * Get IIIF canvas
     * @return mixed
     */
    public function getIiifCanvasAttribute()
    {
        return $this->persistentIdentifier->iiifCanvas;
    }

    /**
     * Get Iiif thumbnail link (that resolves to digilib)
     */
    public function getIiifThumbnailLinkAttribute()
    {
        $imageLink =
            $this->getIiifBaseLinkAttribute() .
            Config::get("constants.digilib.iiif.size.thumbnail");

        return $imageLink;
    }

    /**
     * Get the corresponding IIIF thumbnail
     * @return mixed
     */
    public function getIiifThumbnailAttribute()
    {
        return $this->persistentIdentifier->iiifThumbnail;
    }



}
