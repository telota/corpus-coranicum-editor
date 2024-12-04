<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Enums\FormAction;
use App\Models\Manuscripts\Funder;
use App\Models\Manuscripts\ReadingSign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GenericController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Category $category)
    {

        return view("index", [
            'category' => $category,
            'entities' => $category->indexEntities(),
        ]);
    }

    public function show(Category $category, string $id)
    {

        return view("create_show_edit", [
            'id' => $id,
            'action' => FormAction::Show,
            'category' => $category,
            'entity' => $category->singleEntity($id),
        ]);

    }

    public function edit(Category $category, string $id)
    {

        if ($category == Category::Author && !Auth::user()->isAdmin()) {
            abort(401);
        }

        return view("create_show_edit", [
            'action' => FormAction::Edit,
            'category' => $category,
            'entity' => $category->singleEntity($id),
        ]);

    }

    public function create(Category $category)
    {
        if ($category == Category::Author && !Auth::user()->isAdmin()) {
            abort(401);
        }

        return view("create_show_edit", [
            'action' => FormAction::Create,
            'category' => $category,
            'entity' => $category->newEntity(),
        ]);

    }

    public static function mapRequestToModel(Request $request, $entity, $fields)
    {
        foreach ($fields as $field) {
            if (trim(strip_tags($request->$field)) == "") {
                $entity->$field = null;
            } else {
                $entity->$field = trim($request->$field);
            }
        }
    }

    public function store(Request $request, Category $category, ?string $id = null)
    {


        $entity = isset($id) ? $category->singleEntity($id) : $category->newEntity();
        $request->validate($entity->formFields($id));
        self::mapRequestToModel($request, $entity, collect($entity->formFields())->keys());

        $entity->save();

        if (method_exists($entity, 'syncRelations')) {
            $entity->syncRelations($request);
        }

        return redirect()->route("show", ["category" => $category, "id" => $entity->id]);

    }

}
