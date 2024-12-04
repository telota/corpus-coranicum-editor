<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Veranstaltung extends Model
{
    protected $table = "veranstaltungen";

    /**
     * Get author of this entry
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function autor()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }
}
