<?php

namespace App\Models\Manuscripts;

use App\Models\Koranstelle;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\Routing\Tests\Loader\AnnotationDirectoryLoaderTest;


class ManuscriptPageMapping extends Model
{
    use CreatedUpdatedBy;

    protected $table = "ms_manuscript_pages_mapping";

    public $timestamps = true;
    protected $guarded = [];
    protected $attributes = [
        "sura_start" => 1,
        "verse_start" => 0,
        "word_start" => null,
        "sura_end" => 1,
        "verse_end" => 0,
        "word_end" => null,
    ];

    public function manuscriptPage(): BelongsTo
    {
        return $this->belongsTo(ManuscriptPage::class,'manuscript_page_id','id');
    }

    /**
     * Parse text coordinate to readable string, e.g. 001:001:001-001:003:001
     * @return string
     */
    public function getReadableCoordinatesAttribute()
    {
        $start =
            str_pad($this->attributes["sura_start"], 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->attributes["verse_start"], 3, 0, STR_PAD_LEFT);
        $end =
            str_pad($this->attributes["sura_end"], 3, 0, STR_PAD_LEFT) . ":" .
            str_pad($this->attributes["verse_end"], 3, 0, STR_PAD_LEFT);

        if (isset($this->word_start)) {
            $start .= ":" . str_pad($this->word_start, 3, 0, STR_PAD_LEFT);
        }

        if (isset($this->word_end)) {
            $end .= ":" . str_pad($this->word_end, 3, 0, STR_PAD_LEFT);
        }
        return "$start-$end";
    }

    /**
     * Get all Koranstellen for this mapping
     * @return \Illuminate\Support\Collection
     */
    public function getKoranstellenAttribute()
    {
        return Koranstelle::getWordsWithinRange(
            $this->attributes["sura_start"],
            $this->attributes["verse_start"],
            $this->attributes["word_start"],
            $this->attributes["sura_end"],
            $this->attributes["verse_end"],
            $this->attributes["word_end"]
        );
    }

}
