<?php

namespace App\Http\Controllers;

use App\Events\UpdateIntertextSourceAuthorEvent;
use App\Models\Intertexts\Author;
use App\Models\Intertexts\SourceAuthor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IntertextSourceAuthorController extends Controller
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
        $authors = SourceAuthor::all();

        return view("intertext_source_authors.index", compact([
            "authors"
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
        $author = new SourceAuthor();

        // Fetch attributes fo an author
        $columns = Schema::getColumnListing('it_source_authors');

        $action = array('App\Http\Controllers\IntertextSourceAuthorController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $author[$column] = null;
            }

        }

        return view("intertext_source_authors.create", compact([
            "author",
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
        $author = $this->createUpdate($request);

        // Save new place
        $author->save();

        return view("intertext_source_authors.show", compact("author"));
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
        $author = SourceAuthor::find($id);

        return view("intertext_source_authors.show", compact(["author"]));
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
        $author = SourceAuthor::find($id);

        $action = array('App\Http\Controllers\IntertextSourceAuthorController@update', $id);


        return view("intertext_source_authors.edit", compact([
            "author",
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
        $author = $this->createUpdate($request, $id);

        // Save new place
        $author->save();

        return view("intertext_source_authors.show", compact("author"));

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

        $author = new SourceAuthor();

        if (!empty($id)) {
            $author = SourceAuthor::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at", "info_authors"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $author[$parameter] = $content;

            }

        }

        if (!empty($id)) event(new UpdateIntertextSourceAuthorEvent($request, $id));


        if (!$author->created_by)
            $author->created_by = Auth::user()->name;

        $author->updated_by = Auth::user()->name;

        $author->updated_at = Carbon::now();

        return $author;
    }
}
