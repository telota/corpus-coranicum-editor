<?php

namespace App\Http\Controllers;

use App\Models\Intertexts\Author;
use App\Models\Intertexts\OriginalLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IntertextOriginalLanguageController extends Controller
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
        $languages = OriginalLanguage::all();

        return view("intertext_original_languages.index", compact([
            "languages"
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get place
        $language = new OriginalLanguage();

        // Fetch attributes fo a author
        $columns = Schema::getColumnListing('it_original_languages');

        $action = array('App\Http\Controllers\IntertextOriginalLanguageController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $language[$column] = null;
            }

        }

        return view("intertext_original_languages.create", compact([
            "language",
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
        $language = $this->createUpdate($request);

        // Save new place
        $language->save();

        return view("intertext_original_languages.show", compact("language"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get language
        $language = OriginalLanguage::find($id);

        return view("intertext_original_languages.show", compact(["language"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get language
        $language = OriginalLanguage::find($id);

        $action = array('App\Http\Controllers\IntertextOriginalLanguageController@update', $id);


        return view("intertext_original_languages.edit", compact([
            "language",
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
        $language = $this->createUpdate($request, $id);

        // Save new place
        $language->save();

        return view("intertext_original_languages.show", compact("language"));

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

        $language = new OriginalLanguage();

        if (!empty($id)) {
            $language = OriginalLanguage::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $language[$parameter] = $content;

            }

        }

        if (!$language->created_by)
            $language->created_by = Auth::user()->name;

        $language->updated_by = Auth::user()->name;

        $language->updated_at = Carbon::now();

        return $language;
    }
}
