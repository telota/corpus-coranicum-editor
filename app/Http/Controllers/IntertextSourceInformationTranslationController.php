<?php

namespace App\Http\Controllers;

use App\Models\Intertexts\Author;
use App\Models\Intertexts\IntertextSource;
use App\Models\Intertexts\SourceInformationTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IntertextSourceInformationTranslationController extends Controller
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
    public function create($sourceId)
    {

        $source = IntertextSource::find($sourceId);
        // Get place
        $infoTranslation = new SourceInformationTranslation();

        // Fetch attributes fo a author
        $columns = Schema::getColumnListing('it_source_information_translations');

        $action = array('App\Http\Controllers\IntertextSourceInformationTranslationController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $infoTranslation[$column] = null;
            }

        }
        $infoTranslation->source_id = $sourceId;

        return view("intertext_source_information_translations.create", compact([
            "infoTranslation",
            "source",
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
        $infoTranslation = $this->createUpdate($request);
        $source = $infoTranslation->source;
        // Save new place
        $infoTranslation->save();

        return view("intertext_source_information_translations.show", compact("infoTranslation", "source"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $infoTranslation = SourceInformationTranslation::find($id);

        $source = $infoTranslation->source;

        return view("intertext_source_information_translations.show", compact(["infoTranslation", "source"]));
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
        $infoTranslation = SourceInformationTranslation::find($id);
//        dd($entryTranslation);

        $source = $infoTranslation->source;

        $action = array('App\Http\Controllers\IntertextSourceInformationTranslationController@update', $id);


        return view("intertext_source_information_translations.edit", compact([
            "infoTranslation",
            "source",
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
        $infoTranslation = $this->createUpdate($request, $id);

        // Save new place
        $infoTranslation->save();

        return view("intertext_source_information_translations.show", compact("infoTranslation"));

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

        $infoTranslation = new SourceInformationTranslation();

        if (!empty($id)) {
            $infoTranslation = SourceInformationTranslation::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $infoTranslation[$parameter] = $content;

            }

        }

        if (!$infoTranslation->created_by)
            $infoTranslation->created_by = Auth::user()->name;

        $infoTranslation->updated_by = Auth::user()->name;

        $infoTranslation->updated_at = Carbon::now();

//        if (!empty($id)) event(new UpdateIntertextSourceEvent($request, $id));

        return $infoTranslation;
    }
}
