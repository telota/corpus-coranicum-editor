<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;


class IntertextCategory extends Model
{
    protected $table = "it_categories";

    public $incrementing = false;

    public $timestamps = true;

    protected $guarded = [];

    public $editAlter = array(
        "supercategory"
    );

    public $editIgnore = array(
        "id",
        "created_at",
        "updated_at",
        "updated_by",
        "created_by"
    );

    public $editLarge = array(
        "source_information_text"
    );
    /**
     * Get Umwelttexte for this category
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function intertexts()
    {
        return $this->hasMany(Intertext::class, 'category_id');
    }

    /**
     * Get Umwelttexte for this category
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function infoAuthors()
    {
        return $this->hasMany(CategoryInformationAuthor::class, 'category_id');
    }

    public static function getInfoAuthorsImplode($category)
    {
        return implode(", ", array_map(function($author) {return $author->author()->get()->all()[0]["author_name"];}, $category->infoAuthors()->get()->all()));
    }

    public function infoTranslations()
    {
        return $this->hasMany(CategoryInformationTranslation::class, 'category_id');
    }

    /**
     * Get available authors
     * @return array
     */
    public static function getAuthors()
    {
        return array_column(InformationAuthor::all()->all(), 'id','author');
    }

    /**
     * Get readable name for the category, including id
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->id}: {$this->category_name}";
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

    /**
     * Get all Aufbewahrungsorte and format them into an array
     * for form creation.
     *
     * @return array
     */
    public static function getAllSuperCategoriesSelect()
    {
        $superCategories = IntertextCategory::all();

        $return = array();

        $return[0] = "Oberkategorie auswählen...";

        foreach ($superCategories as $superCategory) {

            $return[$superCategory->id] = $superCategory->category_name;
        }

        return $return;
    }

}
