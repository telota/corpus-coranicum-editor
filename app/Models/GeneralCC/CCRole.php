<?php

namespace App\Models\GeneralCC;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;

class CCRole extends Model
{
    use CreatedUpdatedBy;
    protected $table = "cc_roles";

    protected $guarded = [
        "id"
    ];

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

    public $editAlter =
        array(
            "module_id"
        );

    public $editLarge =
        array(
            "role_description"
        );

    public function module()
    {
        return $this->hasOne(Module::class, 'id', 'module_id');
    }

    public function authors()
    {
        return $this->hasMany(AuthorRole::class, 'role_id', 'id');
    }

    public static function roleKey(CCRole $r): string
    {
        return $r->module->module_name . "_" . $r->role_name;
    }

    public static function roleLabel(CCRole $r): string
    {

        return ucfirst($r->module->module_name) . " " . ucfirst($r->role_name);
    }

    /**
     * Get all Roles and format them into an array
     * for form creation.
     *
     * @return array
     */
    public
    static function getAllSelect()
    {
        $roles = CCRole::all();

        $return = array();

        $return[""] = "Rolle auswählen...";

        foreach ($roles as $role) {

            $return[$role->id] = $role->module->module_name . ' - ' . $role->role_name;
        }

        return $return;
    }
}
