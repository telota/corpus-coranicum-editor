<?php

namespace App\Http\Controllers;

use App\Models\Manuscripts\ManuscriptTransliterationAuthor;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class ManuscriptTransliterationAuthorController extends Controller
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
        $transliterationAuthors = ManuscriptTransliterationAuthor::all();

        return view("transliteration_authors.index", compact([
            "transliterationAuthors"
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
        $transliterationAuthor = new ManuscriptTransliterationAuthor();

        // Fetch attributes fo a transliterationAuthor
        $columns = Schema::getColumnListing('ms_transliteration_authors');

        $action = array('App\Http\Controllers\ManuscriptTransliterationAuthoController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $transliterationAuthor[$column] = null;
            }

        }

        return view("transliteration_authors.create", compact([
            "transliterationAuthor",
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
        $transliterationAuthor = $this->createUpdate($request);

        // Save new place
        $transliterationAuthor->save();

        return view("transliteration_authors.show", compact("transliterationAuthor"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get transliterationAuthor
        $transliterationAuthor = ManuscriptTransliterationAuthor::find($id);

        return view("transliteration_authors.show", compact(["transliterationAuthor"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get transliterationAuthor
        $transliterationAuthor = ManuscriptTransliterationAuthor::find($id);

        $action = array('App\Http\Controllers\ManuscriptTransliterationAuthoController@update', $id);


        return view("transliteration_authors.edit", compact([
            "transliterationAuthor",
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
        $transliterationAuthor = $this->createUpdate($request, $id);

        // Save new place
        $transliterationAuthor->save();

        return view("transliteration_authors.show", compact("transliterationAuthor"));

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
     * @return ManuscriptTransliterationAuthor
     */
    private function createUpdate(Request $request, $id = null)
    {

        $transliterationAuthor = new ManuscriptTransliterationAuthor();

        if (!empty($id)) {
            $transliterationAuthor = ManuscriptTransliterationAuthor::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $transliterationAuthor[$parameter] = $content;

            }

        }

        return $transliterationAuthor;
    }
}
