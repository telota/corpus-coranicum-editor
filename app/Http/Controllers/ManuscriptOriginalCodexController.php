<?php

namespace App\Http\Controllers;

use App\Models\Manuscripts\ManuscriptOriginalCodex;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ManuscriptOriginalCodexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manuskriptOriginalCodex = ManuscriptOriginalCodex::where('id', '>', 1)->get();
//        $manuskriptOriginalCodex = array_shift($manuskriptOriginalCodex);
//    dd($manuskriptOriginalCodex);

        return view("original_codex.index", compact("manuskriptOriginalCodex"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $manuskriptOriginalCodex = new ManuscriptOriginalCodex();
        $manuskriptOriginalCodexes = ManuscriptOriginalCodex::all();

        $superKategorien = [[1, "keine"]];
        foreach ($manuskriptOriginalCodexes as $codex) {
            if ($codex->supercategory == 1) {
                array_push($superKategorien, [$codex->id, $codex->original_codex_name]);
            }
        }

        $action = array('App\Http\Controllers\ManuscriptOriginalCodexController@store');

        return view("original_codex.create", compact(["manuskriptOriginalCodex", "superKategorien", "action"]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $manuskriptOriginalCodex = ManuscriptOriginalCodex::create($request->all());

        $manuskriptOriginalCodex->created_by = Auth::user()->name;

        $manuskriptOriginalCodex->save();

        return redirect()->action([ManuscriptOriginalCodexController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get original codex
        $originalCodex = ManuscriptOriginalCodex::find($id);

        return view("original_codex.show", compact(["originalCodex"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manuskriptOriginalCodex = ManuscriptOriginalCodex::find($id);
        $manuskriptOriginalCodexes = ManuscriptOriginalCodex::all();


        $superKategorien = [[1, "keine"]];
        foreach ($manuskriptOriginalCodexes as $codex) {
            if ($codex->supercategory == 1) {
                array_push($superKategorien, [$codex->id, $codex->original_codex_name]);
            }
        }

        $action = array('App\Http\Controllers\ManuscriptOriginalCodexController@update', $id);
        return view("original_codex.edit", compact(["manuskriptOriginalCodex", "superKategorien", "action"]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $manuskriptOriginalCodex = ManuscriptOriginalCodex::find($id);
        $manuskriptOriginalCodex->original_codex_name = $request->original_codex_name;
        $manuskriptOriginalCodex->supercategory = $request->supercategory;
        $manuskriptOriginalCodex->script_style_id = $request->script_style_id;

        if (!$manuskriptOriginalCodex->created_by)
            $manuskriptOriginalCodex->created_by = Auth::user()->name;
        $manuskriptOriginalCodex->updated_by = Auth::user()->name;

        $manuskriptOriginalCodex->updated_at = Carbon::now();

        $manuskriptOriginalCodex->save();
        return redirect()->action([ManuscriptOriginalCodexController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
