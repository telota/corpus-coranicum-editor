<?php

namespace App\Http\Controllers;

use App\Models\Intertexts\Author;
use App\Models\Intertexts\Intertext;
use App\Models\Intertexts\IntertextEntryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IntertextEntryTranslationController extends Controller
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
        $entryTranslation = new IntertextEntryTranslation();

        // Fetch attributes fo a author
        $columns = Schema::getColumnListing('it_intertext_entry_translations');

        $action = array('App\Http\Controllers\IntertextEntryTranslationController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $entryTranslation[$column] = null;
            }

        }
        $entryTranslation->intertext_id = $intertextId;

        return view("intertext_entry_translations.create", compact([
            "entryTranslation",
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
        $entryTranslation = $this->createUpdate($request);
        $intertext = $entryTranslation->intertext;
        // Save new place
        $entryTranslation->save();

        return view("intertext_entry_translations.show", compact("entryTranslation", "intertext"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $entryTranslation = IntertextEntryTranslation::find($id);

        $intertext = $entryTranslation->intertext;

        return view("intertext_entry_translations.show", compact(["entryTranslation", "intertext"]));
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
        $entryTranslation = IntertextEntryTranslation::find($id);
//        dd($entryTranslation);

        $intertext = $entryTranslation->intertext;

        $action = array('App\Http\Controllers\IntertextEntryTranslationController@update', $id);


        return view("intertext_entry_translations.edit", compact([
            "entryTranslation",
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
        $entryTranslation = $this->createUpdate($request, $id);

        // Save new place
        $entryTranslation->save();

        return view("intertext_entry_translations.show", compact("entryTranslation"));

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

        $entryTranslation = new IntertextEntryTranslation();

        if (!empty($id)) {
            $entryTranslation = IntertextEntryTranslation::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at","intertext", "language"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $entryTranslation[$parameter] = $content;

            }

        }

//        if (!empty($id)) event(new UpdateIntertextSourceEvent($request, $id));

        if (!$entryTranslation->created_by)
            $entryTranslation->created_by = Auth::user()->name;

        $entryTranslation->updated_by = Auth::user()->name;

        $entryTranslation->updated_at = Carbon::now();

        return $entryTranslation;
    }
}
