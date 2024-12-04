<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Models\CollegiumCoranicum;
use App\Models\Veranstaltung;
use App\Rules\HtmlHasText;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class VeranstaltungController extends Controller
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
        $form_fields = [
            'ort' => 'required',
            'titel' => 'required',
            'beschreibung' => [new HtmlHasText()],
        ];

        $special_fields = [
            'datum_start_day' => "required",
            'datum_start_time' => "required",
            'datum_ende_day' => "required",
            'datum_ende_time' => "required",
        ];

        $request->validate($form_fields);
        $request->validate($special_fields);


        GenericController::mapRequestToModel($request, $entity, collect($form_fields)->keys());

        $entity->datum_start = $request->datum_start_day . " " . $request->datum_start_time;
        $entity->datum_ende = $request->datum_ende_day . " " . $request->datum_ende_time;
        $entity->user_id = Auth::user()->id;

        $entity->save();

        return $entity;


    }

    public function store(Request $request, ?string $id = null)
    {

        $entity = isset($id) ? Veranstaltung::findOrFail($id) : new Veranstaltung();

        $entity = self::save($request, $entity);

        return redirect()->route("show", ["category" => Category::Veranstaltung, "id" => $entity->id]);


    }

}
