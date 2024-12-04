<?php

namespace App\Http\Controllers;

use App\Models\Koranstelle;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Sure;

class KoranController extends Controller
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

        $words = Koranstelle::getAllWordsAndHeaders();

        return view("koran.index", compact("words"));
    }

    public function indexBySura($sure = 1)
    {

        $words = Koranstelle::getAllWordsAndHeadersBySura($sure);

        return view("koran.index", compact("words", "sure"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $sure
     * @param $vers
     * @param $wort
     * @return \Illuminate\Http\Response
     */
    public function edit($sure, $vers, $wort)
    {

        $koranstelle = Koranstelle::where([
            "sure" => $sure,
            "vers" => $vers,
            "wort" => $wort
        ])->first();

        return view("koran.edit", compact("koranstelle"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $sure
     * @param int $vers
     * @param int $sure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sure, $vers, $wort)
    {

        $this->validate($request, [
            "transcription" => "required"
        ]);

        $koranstelle = Koranstelle::where([
            "sure" => $sure,
            "vers" => $vers,
            "wort" => $wort
        ])->first();

        $koranstelle->transkription = $request->transcription;

        $koranstelle->save();

        return redirect()->action([KoranController::class, 'indexBySura'], $sure);
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

    public function getMaxWords()
    {
        return response()->json(Sure::getMaxWords());
    }

    public function getVerse(Request $request, $sura, $verse){

        return response()->json(Koranstelle::getVers($sura, $verse));

    }
}
