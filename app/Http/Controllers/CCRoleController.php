<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Models\CollegiumCoranicum;
use App\Models\GeneralCC\CCAuthor;
use App\Models\GeneralCC\CCRole;
use App\Models\Veranstaltung;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CCRoleController extends Controller
{

    /**
     * Only allow access when logged in
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function save(Request $request, $entity)
    {

        collect(['author_name'])->each(function ($field) use ($request, $entity) {
            if (trim(strip_tags($request->$field)) == "") {
                $entity->$field = null;
            } else {
                $entity->$field = trim($request->$field);
            }

        }
        );

        $entity->save();

        $role_key_to_id = CCRole::with('module')
            ->get()
            ->mapWithKeys(fn($r) => [CCRole::roleKey($r) => $r->id]);

        $role_ids = $request->collect('roles')
            ->map(fn($role_key)=>$role_key_to_id[$role_key])
            ->filter(fn($e) => isset($e));

        $entity->roles()->sync($role_ids);


    }

    public function store(Request $request, ?string $id = null)
    {
        $entity = isset($id) ? CCAuthor::findOrFail($id) : new CCAuthor();

        self::save($request, $entity);

        return redirect()->route("show", ["category" => Category::Author, "id" => $entity->id]);


    }

}
