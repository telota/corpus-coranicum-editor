<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Glossareintrag extends Model
{
    protected $table = "glossarium";

    public function formFields()
    {
        return [
            "wort" => "required",
            "wurzel" => [],
            "literatur" => [],
            "anmerkungen" => [],
            "bearbeiter" => []
        ];

    }

    public $timestamps = false;

    public function belege()
    {
        return $this->hasMany(Glossarbeleg::class, 'glossarium_id', 'id');
    }

}
