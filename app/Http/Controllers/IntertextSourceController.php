<?php

namespace App\Http\Controllers;

use App\Events\UpdateIntertextSourceEvent;
use App\Models\Intertexts\Author;
use App\Models\Intertexts\IntertextSource;
use App\Models\Intertexts\SourceAuthor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class IntertextSourceController extends Controller
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
        $sources = IntertextSource::all();

        return view("intertext_sources.index", compact([
            "sources"
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
        $source = new IntertextSource();

        // Fetch attributes fo a author
        $columns = Schema::getColumnListing('it_sources');

        $action = array('App\Http\Controllers\IntertextSourceController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $source[$column] = null;
            }

        }

        return view("intertext_sources.create", compact([
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
        $source = $this->createUpdate($request);

        // Save new place
        $source->save();

        return view("intertext_sources.show", compact("source"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get author
        $source = IntertextSource::find($id);

        return view("intertext_sources.show", compact(["source"]));
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
        $source = IntertextSource::find($id);
//    dd($source);
        $action = array('App\Http\Controllers\IntertextSourceController@update', $id);


        return view("intertext_sources.edit", compact([
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
        $source = $this->createUpdate($request, $id);

        // Save new place
        $source->save();

        return view("intertext_sources.show", compact("source"));

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

        $source = new IntertextSource();

        if (!empty($id)) {
            $source = IntertextSource::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at", "info_authors"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $source[$parameter] = $content;

            }

        }

        if (!empty($id)) event(new UpdateIntertextSourceEvent($request, $id));

        if (!$source->created_by)
            $source->created_by = Auth::user()->name;

        $source->updated_by = Auth::user()->name;

        $source->updated_at = Carbon::now();

        return $source;
    }
}
