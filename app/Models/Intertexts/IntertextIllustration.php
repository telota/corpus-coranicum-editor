<?php

namespace App\Models\Intertexts;

use Illuminate\Database\Eloquent\Model;


class IntertextIllustration extends Model
{
    public $table = "it_intertext_illustrations";

    public $timestamps = true;

    protected $fillable = ['id'];

}
