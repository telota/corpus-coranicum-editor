<?php

namespace App\Http\Controllers;

use App\Models\Intertexts\Author;
use App\Models\Intertexts\Intertext;
use App\Models\Intertexts\IntertextOriginalTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IntertextOriginalTranslationController extends Controller
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
    public function create($intertextId)
    {

        $intertext = Intertext::find($intertextId);
        // Get place
        $originalTranslation = new IntertextOriginalTranslation();

        // Fetch attributes fo a author
        $columns = Schema::getColumnListing('it_intertext_source_text_original_translations');

        $action = array('App\Http\Controllers\IntertextOriginalTranslationController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $originalTranslation[$column] = null;
            }

        }
        $originalTranslation->intertext_id = $intertextId;

        return view("intertext_original_translations.create", compact([
            "originalTranslation",
            "intertext",
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
        $originalTranslation = $this->createUpdate($request);
        $intertext = $originalTranslation->intertext;

        // Save new place
        $originalTranslation->save();

        return view("intertext_original_translations.show", compact("originalTranslation", "intertext"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $originalTranslation = IntertextOriginalTranslation::find($id);

        $intertext = $originalTranslation->intertext;

        return view("intertext_original_translations.show", compact(["originalTranslation", "intertext"]));
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
        $originalTranslation = IntertextOriginalTranslation::find($id);

        $intertext = $originalTranslation->intertext;

        $action = array('App\Http\Controllers\IntertextOriginalTranslationController@update', $id);


        return view("intertext_original_translations.edit", compact([
            "originalTranslation",
            "intertext",
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
        $originalTranslation = $this->createUpdate($request, $id);

        // Save new place
        $originalTranslation->save();

        return view("intertext_original_translations.show", compact("originalTranslation"));

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

        $originalTranslation = new IntertextOriginalTranslation();

        if (!empty($id)) {
            $originalTranslation = IntertextOriginalTranslation::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $originalTranslation[$parameter] = $content;

            }

        }

        if (!$originalTranslation->created_by)
            $originalTranslation->created_by = Auth::user()->name;

        $originalTranslation->updated_by = Auth::user()->name;

        $originalTranslation->updated_at = Carbon::now();

//        if (!empty($id)) event(new UpdateIntertextSourceEvent($request, $id));

        return $originalTranslation;
    }
}
