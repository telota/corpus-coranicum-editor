<?php

namespace App\Models\GeneralCC;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CCAuthor extends Model
{
    use CreatedUpdatedBy;
    protected $table = "cc_authors";

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
            "created_at",
            "updated_by",
            "created_by"
        );

    public $editLarge =
        array(
            "author_description"
        );

    public function roles()
    {
        return $this->belongsToMany(CCRole::class, 'cc_author_roles', 'author_id', 'role_id');
    }

    public static function hasRole(CCAuthor $author, string $role, string $module): bool
    {

        $role = $author
            ->roles()
            ->where('role_name', $role)
            ->whereHas('module', fn($q) => $q->where('module_name', $module))
            ->first();

        return $role ? true : false;
    }

    public static function getAuthorsWithRole($moduleName, $roleName)
    {

        return CCAuthor::with('roles.module')
            ->whereHas('roles', fn($q)=>$q->where('role_name',$roleName))
            ->whereHas('roles.module', fn($q)=>$q->where('module_name',$moduleName))
            ->get();
    }

}
