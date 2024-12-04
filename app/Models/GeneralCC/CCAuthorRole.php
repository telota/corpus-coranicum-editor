<?php

namespace App\Models\GeneralCC;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CCAuthorRole extends Model
{
    use CreatedUpdatedBy;
    protected $table = "cc_author_roles";

    public $timestamps = true;

    public function author(){
        return $this->belongsTo(CCAuthor::class,"author_id", "id");
    }

    public function role(){
        return $this->belongsTo(CCRole::class,"role_id", "id");
    }

}
