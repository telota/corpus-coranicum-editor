<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;


class InformationAuthor extends Model
{
    protected $table = "it_information_authors";

    protected $guarded = ["id"];

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
            "created_at"
        );


    /**
     * Get associated manuscript
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sources()
    {
        return $this->hasMany(SourceInformationAuthor::class, "info_author_id");
    }

    /**
     * Get associated author
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(CategoryInformationAuthor::class, "info_author_id");
    }

    /**
     * Get available authors
     * @return array
     */
    public static function getInfoAuthors()
    {
        return array_column(InformationAuthor::all()->all(), 'id','author_name');
    }

    /**
     * Get all Aufbewahrungsorte and format them into an array
     * for form creation.
     *
     * @return array
     */
    public static function getAllSelect()
    {
        $authors = InformationAuthor::all();

        $return = array();

        $return[""] = "CCAuthor auswählen...";

        foreach ($authors as $author) {

            $return[$author->id] = $author->author_name;
        }

        return $return;
    }
}
