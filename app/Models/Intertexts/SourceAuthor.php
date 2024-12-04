<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;

class SourceAuthor extends Model
{
    protected $table = "it_source_authors";

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
        "author_name"
    );

    public function sources()
    {
        return $this->hasMany(IntertextSource::class, 'author_id');
    }

    public function infoAuthors()
    {
        return $this->hasMany(SourceAuthorInformationAuthor::class, 'author_id');
    }

    public static function getInfoAuthorsImplode($sourceAuthor)
    {
        return implode(", ", array_map(function($author) {return $author->infoAuthor()->get()->all()[0]["author_name"];}, $sourceAuthor->infoAuthors()->get()->all()));
    }

    public function infoTranslations()
    {
        return $this->hasMany(SourceAuthorInformationTranslation::class, 'source_author_id');
    }

    /**
     * Get all Aufbewahrungsorte and format them into an array
     * for form creation.
     *
     * @return array
     */
    public static function getAllSelect()
    {
        $authors = SourceAuthor::all();

        $return = array();

        $return[""] = "CCAuthor auswählen...";

        foreach ($authors as $author) {

            $return[$author->id] = $author->author_name;
        }

        return $return;
    }

}
