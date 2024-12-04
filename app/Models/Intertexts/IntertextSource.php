<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;

class IntertextSource extends Model
{
    protected $table = "it_sources";

    protected $guarded = [
        "id"
    ];

    public $timestamps = true;

    /**
     * Attributes that should not be shown in the editing view
     *
     * @return array
     */
    public $editIgnore =
            array(
                "id",
                "updated_at",
                "created_at",
                "updated_by",
                "created_by"
            );

    public $editLarge = array(
        "source_information_text"
    );

    public $editAlter = array(
        "author_id",
        "is_valid_source"
    );

    public function author()
    {
        return $this->hasOne(SourceAuthor::class, 'id', 'author_id');
    }

    public function getAuthorName()
    {
        return $this->author()->first()->author_name;
    }

    public function intertexts()
    {
        return $this->hasMany(Intertext::class, 'source_id');
    }

    public function infoAuthors()
    {
        return $this->hasMany(SourceInformationAuthor::class, 'source_id');
    }

    public function infoTranslations()
    {
        return $this->hasMany(SourceInformationTranslation::class, 'source_id');
    }

    public static function getInfoAuthorsImplode($source)
    {
        return implode(", ", array_map(function($author) {return $author->infoAuthor()->get()->all()[0]["author_name"];}, $source->infoAuthors()->get()->all()));
    }

    /**
     * Get all Aufbewahrungsorte and format them into an array
     * for form creation.
     *
     * @return array
     */
    public static function getAllSelect()
    {
        $sources = IntertextSource::all();

        $return = array();

        $return[""] = "Source auswählen...";

        foreach ($sources as $source) {
//    dd($book->author()->first()->author_name);
            $return[$source->id] = $source->source_name . ' - ' . $source->author()->first()->author_name;
        }

        return $return;
    }
}
