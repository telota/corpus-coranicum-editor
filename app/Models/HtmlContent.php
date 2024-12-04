<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HtmlContent extends Model
{
    use CreatedUpdatedBy;
    use HasFactory;

    protected $table = "html_content";

    public $timestamps = true;

    public function formFields()
    {
        return [
            "label" => "required",
            "de" => [],
            "en" => [],
            "fr" => [],
        ];
    }

}
