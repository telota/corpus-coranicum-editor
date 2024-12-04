<?php

namespace App\Http\Controllers;

use App\Models\Glossareintrag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class GlossarController extends Controller
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
        // Get all glossary entries
        $glossar =  Glossareintrag::all();

        return view("glossar.index", compact("glossar"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Create new eintrag
        $eintrag = new Glossareintrag();

        $columns = Schema::getColumnListing("glossarium");

        foreach($columns as $column)
        {
            $eintrag[$column] = "";
        }

        $action = ['App\Http\Controllers\GlossarController@store'];

        return view("glossar.create_update", compact("eintrag", "action"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create new eintrag
        $eintrag = $this->createUpdate($request, new Glossareintrag());

        $eintrag->save();

        Session::flash("flash_message", "Glossareintrag wurde erfolgreich erstellt.");
        Session::flash("flash_type", "alert-success");

        return redirect()->action([GlossarController::class, 'show'], $eintrag->ID);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get glossary entry
        $eintrag = Glossareintrag::find($id);

        return view("glossar.show", compact("eintrag"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get Eintrag
        $eintrag = Glossareintrag::find($id);

        $action = array('App\Http\Controllers\GlossarController@update', $id);

        return view("glossar.create_update", compact("action", "eintrag"));
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
        // Get eintrag
        $eintrag = $this->createUpdate($request, Glossareintrag::find($id));

        $eintrag->save();

        Session::flash("flash_message", "Glossareintrag wurde erfolgreich aktualisiert");
        Session::flash("flash_type", "alert-success");

        return redirect()->action([GlossarController::class, 'show'], $id);
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

    private static function createUpdate(Request $request, $eintrag)
    {

        foreach($request->except("_token", "files") as $attribute => $content)
        {
            $eintrag[$attribute] = $content;
        }

        return $eintrag;

    }
}
