<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Models\CollegiumCoranicum;
use App\Models\Veranstaltung;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CollegiumCoranicumController extends Controller
{
    public function store(Request $request, ?string $id = null)
    {
        $entity = isset($id) ? CollegiumCoranicum::findOrFail($id) : new CollegiumCoranicum();
        $entity = VeranstaltungController::save($request, $entity);
        return redirect()->route("show", ["category" => Category::CollegiumCoranicum, "id" => $entity->id]);
    }

}
