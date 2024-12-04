<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Glossarbeleg extends Model
{
    protected $table = "glossarbelege";

    protected $primaryKey = "id";

    public $timestamps = false;

    public function formFields()
    {
        return [
            "glossarium_id" => "required",
            "typ" => [],
            "belegstelle" => "required",
            "bearbeiter" => [],
            "ort" => [],
            "datierung" => [],
            "uebersetzung_nachweis" => [],
            "originaltext" => [],
            "umschrift" => [],
            "bildlink" => [],
            "edition" => [],
            "uebersetzung" => [],
            "anmerkung" => [],
            "sprache" => [],
        ];
    }

    public function eintrag()
    {
        return $this->hasOne(Glossareintrag::class, "id", "glossarium_id");
    }

}
