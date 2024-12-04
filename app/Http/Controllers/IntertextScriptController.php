<?php

namespace App\Http\Controllers;

use App\Models\Intertexts\Author;
use App\Models\Intertexts\Script;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IntertextScriptController extends Controller
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
        $scripts = Script::all();

        return view("intertext_scripts.index", compact([
            "scripts"
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
        $script = new Script();

        // Fetch attributes fo a author
        $columns = Schema::getColumnListing('it_scripts');

        $action = array('App\Http\Controllers\IntertextScriptController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id")) {
                $script[$column] = null;
            }

        }

        return view("intertext_scripts.create", compact([
            "script",
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
        $script = $this->createUpdate($request);

        // Save new place
        $script->save();

        return view("intertext_scripts.show", compact("script"));
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
        $script = Script::find($id);

        return view("intertext_scripts.show", compact(["script"]));
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
        $script = Script::find($id);

        $action = array('App\Http\Controllers\IntertextScriptController@update', $id);


        return view("intertext_scripts.edit", compact([
            "script",
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
        $script = $this->createUpdate($request, $id);

        // Save new place
        $script->save();

        return view("intertext_scripts.show", compact("script"));

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

        $script = new Script();

        if (!empty($id)) {
            $script = Script::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $script[$parameter] = $content;

            }

        }

        if (!$script->created_by)
            $script->created_by = Auth::user()->name;

        $script->updated_by = Auth::user()->name;

        $script->updated_at = Carbon::now();

        return $script;
    }
}
