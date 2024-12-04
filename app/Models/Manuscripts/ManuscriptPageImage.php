<?php

namespace App\Models\Manuscripts;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class ManuscriptPageImage extends Model
{

    use CreatedUpdatedBy;
    public $table = "ms_manuscript_pages_images";

    protected $guarded = ["id"];

    public $timestamps = true;



    /**
     * Get parent manuscript page record of this image
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(ManuscriptPage::class, 'manuscript_page_id', 'id');
    }

    public function manuscript(){
        return $this->hasOneThrough(
            ManuscriptNew::class,
            ManuscriptPage::class,
            'id',
            'id',
            'manuscript_page_id',
            'manuscript_id',
            );
    }

    protected function msCreditLineImage(): Attribute
    {
        $ms_credit = $this->page->manuscript->credit_line_image;



        return Attribute::make(
            get: fn() => isset($ms_credit) && trim($ms_credit) !== "" ? $ms_credit : "(None set)" ,
        );

    }


}
