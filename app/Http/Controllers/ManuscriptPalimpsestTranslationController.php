<?php

namespace App\Http\Controllers;

use App\Models\Intertexts\Author;
use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuscripts\ManuscriptPalimpsestTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ManuscriptPalimpsestTranslationController extends Controller
{

    /**
     * Only allow access when logged in
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($manuscriptId)
    {

        $manuscript = ManuscriptNew::find($manuscriptId);
        // Get place
        $palimpsestTranslation = new ManuscriptPalimpsestTranslation();

        // Fetch attributes fo a author
        $columns = Schema::getColumnListing('ms_manuscript_palimpsest_text_translations');

        $action = array('App\Http\Controllers\ManuscriptPalimpsestTranslationController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $palimpsestTranslation[$column] = null;
            }

        }
        $palimpsestTranslation->manuscript_id = $manuscriptId;

        return view("manuscript_palimpsest_translations.create", compact([
            "palimpsestTranslation",
            "manuscript",
            "action"
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Iterate over all parameters of the request and update the original
        $palimpsestTranslation = $this->createUpdate($request);
        $manuscript = $palimpsestTranslation->manuscript;
        // Save new place
        $palimpsestTranslation->save();

        return view("manuscript_palimpsest_translations.show", compact("palimpsestTranslation", "manuscript"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $palimpsestTranslation = ManuscriptPalimpsestTranslation::find($id);

        $manuscript = $palimpsestTranslation->manuscript;

        return view("manuscript_palimpsest_translations.show", compact(["palimpsestTranslation", "manuscript"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get translation
        $palimpsestTranslation = ManuscriptPalimpsestTranslation::find($id);

        $manuscript = $palimpsestTranslation->manuscript;

        $action = array('App\Http\Controllers\ManuscriptPalimpsestTranslationController@update', $id);


        return view("manuscript_palimpsest_translations.edit", compact([
            "palimpsestTranslation",
            "manuscript",
            "action"
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Iterate over all parameters of the request and update the original
        $palimpsestTranslation = $this->createUpdate($request, $id);

        // Save new place
        $palimpsestTranslation->save();

        return view("manuscript_palimpsest_translations.show", compact("palimpsestTranslation"));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get the manuscript update data return filled manuscript object
     *
     * @param Request $request
     * @param null $id
     * @return Author
     */
    private function createUpdate(Request $request, $id = null)
    {

        $palimpsestTranslation = new ManuscriptPalimpsestTranslation();

        if (!empty($id)) {
            $palimpsestTranslation = ManuscriptPalimpsestTranslation::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at","manuscript", "language"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $palimpsestTranslation[$parameter] = $content;

            }

        }

        if (!$palimpsestTranslation->created_by)
            $palimpsestTranslation->created_by = Auth::user()->name;

        $palimpsestTranslation->updated_by = Auth::user()->name;

        $palimpsestTranslation->updated_at = Carbon::now();

        return $palimpsestTranslation;
    }
}
