<?php

namespace App\Models\Lesarten;

use App\Models\GeneralCC\CCAuthorRole;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Quelle extends Model
{
    use CreatedUpdatedBy;


    protected $table = "lc_quelle";

    public $guarded = ["id"];


    public function formFields($id = null)
    {

        $unique = Rule::unique(self::class, 'abkuerzung');
        if ($id) {
            $unique->ignore($id);
        }
        return [
            "abkuerzung" => ["required", $unique],
            "quelle_arabisch" => "required",
            "autor_arabisch" => "required",
            "anzeigetitel" => "required",
            "autor_langfassung" => "required",
            "todesdatum" => "required",
            "todesdatum_ah" => "",
            "ort" => "",
            "referenz" => "",
            "kanonisch" => "",
            "sort" => "",
        ];
    }

    public function syncRelations(Request $request){
       $this->authors()->sync($request->authors);
    }

    public
    function authors()
    {
        return $this->belongsToMany(
            CCAuthorRole::class,
            QuelleAuthor::class,
            'quelle_id',
            'author_role_id',
        );
    }

    public
    function lesarten()
    {
        return $this->hasMany(Leseart::class, 'quelle_id', 'id');
    }

    /**
     * Get all Quellen as an associative array to populate a select dropdown
     * id => anzeigetitel
     */
    public
    static function getAllSelect()
    {
        $selectQuellen = array();

        $quellen = Quelle::all();

        foreach ($quellen as $quelle) {
            $selectQuellen[$quelle->id] = $quelle->abkuerzung . " - " . $quelle->anzeigetitel;
        }

        natcasesort($selectQuellen);

        return $selectQuellen;
    }
}
