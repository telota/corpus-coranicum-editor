<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CollegiumCoranicum extends Model
{

    protected $table = "collegium_coranicum";

    public function autor()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

}
