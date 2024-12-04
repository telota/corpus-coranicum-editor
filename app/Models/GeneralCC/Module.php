<?php

namespace App\Models\GeneralCC;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = "cc_modules";

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

    public $editLarge =
        array(
            "module_description"
        );

    public function roles()
    {
        return $this->hasMany(CCRole::class, 'module_id');
    }

    /**
     * Get all Roles and format them into an array
     * for form creation.
     *
     * @return array
     */
    public static function getAllSelect()
    {
        $modules = Module::all();

        $return = array();

        $return[""] = "Module auswählen...";

        foreach ($modules as $module) {

            $return[$module->id] = $module->module_name;
        }

        return $return;
    }

}
