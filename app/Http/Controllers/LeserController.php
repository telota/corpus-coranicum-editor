<?php

namespace App\Http\Controllers;

use App\Models\Lesarten\Leser;
use App\Models\Lesarten\LeserAlias;
use App\Models\Umwelttexte\Belegstelle;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use App\Models\ZoteroBibliography;
use App\Models\Umwelttexte\Belegstelle as InterTexts;

class LeserController extends Controller
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
        // Get all quran readers
        $leser = Leser::all();

        return view("leser.index", compact("leser"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Create new reader
        $leser = new Leser();

        $columns = Schema::getColumnListing("lc_leser");

        $action = array('App\Http\Controllers\LeserController@store');

        foreach ($columns as $column) {
            $leser[$column] = "";
        }

        $leser->alias = array();
        $zotero = ZoteroBibliography::forSummernote();
        $intertexts = Belegstelle::forSummernote();

        return view("leser.create_update", compact(["leser", "action", "zotero", "intertexts"]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: Validation

        $leser = $this->createUpdate($request, new Leser());


        return redirect()->action([LeserController::class, 'show'], $leser->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get reader
        $leser = Leser::findOrFail($id);

        return view("leser.show", compact("leser"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get reader
        $leser = Leser::find($id);

        $leser->alias = Leser::find($id)->aliases;

        $action = array('App\Http\Controllers\LeserController@update', $id);
        $zotero = ZoteroBibliography::forSummernote();
        $intertexts = Belegstelle::forSummernote();
        return view("leser.create_update", compact(["leser", "action", "zotero", "intertexts"]));
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

        $leser = $this->createUpdate($request, Leser::find($id));


        return redirect()->action([LeserController::class, 'show'], $leser->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $leser = Leser::find($id);

        if (count($leser->mappings) == 0) {

            $leser->delete();

            Session::flash("flash_type", "alert-success");
            Session::flash("flash_message", "Leser erfolgreich gelöscht");
        } else {

            Session::flash("flash_type", "alert-danger");
            Session::flash("flash_message", "Leser kann nicht gelöscht werden, da ihm Lesarten zugeordnet sind.");
        }

        return redirect()->action([LeserController::class, 'index']);
    }

    /**
     * Unified method to store/update Leser model.
     *
     * @param Request $request
     * @param $leser
     * @return mixed
     */
    private function createUpdate(Request $request, $leser)
    {


        foreach ($request->except("_token", "aliases", "files") as $attribute => $content) {
            $leser[$attribute] = $content;
        }

        foreach (Leser::$notNullStrings as $field) {
            if ($leser->$field == null) {
                $leser->$field = "";
            }
        }

        $leser->save();

        self::updateAliases($request, $leser);

        return $leser;
    }

    /**
     * Method to update Leser aliases
     *
     * @param Request $request
     * @param $leser
     */
    private static function updateAliases(Request $request, $leser)
    {

        // Check if leser have been deleted
        $inputAliases = $request->aliases;

        foreach ($leser->aliases as $leserAlias) {

            if (empty($inputAliases)) {
                $leserAlias->delete();
            } else if (!in_array($leserAlias->alias, $inputAliases)) {

                $leserAlias->delete();
            }
        }


        if (!empty($inputAliases)) {
            // Add new aliases
            foreach ($inputAliases as $inputAlias) {

                // Skip, if alias already exists
                if ($leser->aliases->where("alias", trim($inputAlias))->count() > 0) {
                    continue;
                } else {
                    $newAlias = new LeserAlias();
                    $newAlias->leser = $leser->id;
                    $newAlias->alias = $inputAlias;
                    $newAlias->save();
                }
            }
        }
    }
}
