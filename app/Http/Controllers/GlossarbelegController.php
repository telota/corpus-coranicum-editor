<?php

namespace App\Http\Controllers;

use App\Models\Glossarbeleg;
use App\Models\Glossareintrag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class GlossarbelegController extends Controller
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
        // Get all belege
        $belege = Glossarbeleg::all();

        return view("glossarbelege.index", compact("belege"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($eintragId = null)
    {
        // Create new beleg
        $beleg = new Glossarbeleg();

        $columns = Schema::getColumnListing("glossarium2");

        foreach($columns as $column)
        {
            $beleg[$column] = "";
        }

        $eintraege = Glossareintrag::getAllSelect();

        $action = ['App\Http\Controllers\GlossarbelegController@store'];

        return view("glossarbelege.create_update", compact(
            "beleg",
            "action",
            "eintragId",
            "eintraege"
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $beleg = $this->createUpdate($request, new Glossarbeleg());

        $beleg->save();

        return redirect()->action([GlossarbelegController::class, 'show'], $beleg->Gloss2ID);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get beleg
        $beleg = Glossarbeleg::find($id);

        return view("glossarbelege.show", compact("beleg"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get original beleg
        $beleg = Glossarbeleg::find($id);

        $action = array('App\Http\Controllers\GlossarbelegController@update', $id);

        $eintraege = Glossareintrag::getAllSelect();

        $eintragId = $beleg->Gloss1ID;

        return view("glossarbelege.create_update", compact(
            "beleg",
            "action",
            "eintragId",
            "eintraege"
        ));

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

        $beleg = $this->createUpdate($request, Glossarbeleg::find($id));

        $beleg->save();

        return redirect()->action([GlossarbelegController::class, 'show'], $id);

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

    private static function createUpdate(Request $request, $beleg)
    {

        foreach($request->except(["_token", "files"]) as $attribute => $value)
        {
            $beleg[$attribute] = $value;
        }



        return $beleg;

    }
}
