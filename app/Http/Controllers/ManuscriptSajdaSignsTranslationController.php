<?php

namespace App\Http\Controllers;

use App\Models\Intertexts\Author;
use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuscripts\ManuscriptSajdaSignsTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ManuscriptSajdaSignsTranslationController extends Controller
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
        // Get translation
        $sajdaSignsTranslation = new ManuscriptSajdaSignsTranslation();

        // Fetch attributes fo a author
        $columns = Schema::getColumnListing('ms_manuscript_sajda_signs_text_translations');

        $action = array('App\Http\Controllers\ManuscriptSajdaSignsTranslationController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $sajdaSignsTranslation[$column] = null;
            }

        }
        $sajdaSignsTranslation->manuscript_id = $manuscriptId;

        return view("manuscript_sajda_signs_translations.create", compact([
            "sajdaSignsTranslation",
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
        $sajdaSignsTranslation = $this->createUpdate($request);
        $manuscript = $sajdaSignsTranslation->manuscript;
        // Save new place
        $sajdaSignsTranslation->save();

        return view("manuscript_sajda_signs_translations.show", compact("sajdaSignsTranslation", "manuscript"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $sajdaSignsTranslation = ManuscriptSajdaSignsTranslation::find($id);

        $manuscript = $sajdaSignsTranslation->manuscript;

        return view("manuscript_sajda_signs_translations.show", compact(["sajdaSignsTranslation", "manuscript"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get author
        $sajdaSignsTranslation = ManuscriptSajdaSignsTranslation::find($id);
//        dd($entryTranslation);

        $manuscript = $sajdaSignsTranslation->manuscript;

        $action = array('App\Http\Controllers\ManuscriptSajdaSignsTranslationController@update', $id);


        return view("manuscript_sajda_signs_translations.edit", compact([
            "sajdaSignsTranslation",
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
        $sajdaSignsTranslation = $this->createUpdate($request, $id);

        // Save new place
        $sajdaSignsTranslation->save();

        return view("manuscript_sajda_signs_translations.show", compact("sajdaSignsTranslation"));

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

        $sajdaSignsTranslation = new ManuscriptSajdaSignsTranslation();

        if (!empty($id)) {
            $sajdaSignsTranslation = ManuscriptSajdaSignsTranslation::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at","manuscript", "language"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $sajdaSignsTranslation[$parameter] = $content;

            }

        }

        if (!$sajdaSignsTranslation->created_by)
            $sajdaSignsTranslation->created_by = Auth::user()->name;

        $sajdaSignsTranslation->updated_by = Auth::user()->name;

        $sajdaSignsTranslation->updated_at = Carbon::now();

        return $sajdaSignsTranslation;
    }
}
