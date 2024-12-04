<?php

namespace App\Http\Controllers;

use App\Models\Umwelttexte\BelegstellenKategorie;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BelegstellenKategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $belegstellenKategorie = BelegstellenKategorie::all();


        return view("belegstellen.show", compact("belegstellenKategorie"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $belegstellenKategorie = new BelegstellenKategorie();
        $belegstellenKategorien = BelegstellenKategorie::all();


        $superKategorien = [[0, "keine"]];
        foreach($belegstellenKategorien as $kategorie){
            if($kategorie->supercategory == 0){
                array_push($superKategorien, [$kategorie->id, $kategorie->name]);
            }
        }
        $action = array('App\Http\Controllers\BelegstellenKategorieController@store');

        return view("belegstellen.create_update", compact(["belegstellenKategorie", "superKategorien", "action"]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $belegstellenKategorie = BelegstellenKategorie::create($request->all());

        $belegstellenKategorie->save();
        return redirect()->action([BelegstellenKategorieController::class, 'index']);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $belegstellenKategorie = BelegstellenKategorie::find($id);
        $belegstellenKategorien = BelegstellenKategorie::all();


        $superKategorien = [[0, "keine"]];
        foreach($belegstellenKategorien as $kategorie){
                if($kategorie->supercategory == 0){
                    array_push($superKategorien, [$kategorie->id, $kategorie->name]);
                }
            }

        $action = array('App\Http\Controllers\BelegstellenKategorieController@update', $id);
        return view("belegstellen.create_update", compact(["belegstellenKategorie","superKategorien","action"]));
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
        $belegstelle = BelegstellenKategorie::find($id);
        $belegstelle->name = $request->name;
        $belegstelle->supercategory = $request->supercategory;
        $belegstelle->save();
        return redirect()->action([BelegstellenKategorieController::class, 'index']);
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
}
