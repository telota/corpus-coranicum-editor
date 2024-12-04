<?php

namespace App\Http\Controllers;

use App\Models\Paret;
use App\Models\KoranUebersetzung;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DruckausgabeController extends Controller
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
     * @param null $sure
     * @param null $sprache
     * @return \Illuminate\Http\Response
     */
    public function index($sure = null, $sprache = null)
    {

        $translations = null;

        if ($sure && $sprache) {
            // Get only translations for the selected sura
            $translations = KoranUebersetzung::where([
                'sure' => $sure,
                'sprache' => $sprache
            ])->get();
        } elseif ($sure && $sprache == null) {
            $translations = KoranUebersetzung::where([
                'sure' => $sure,
                'sprache' => 'de'
            ])->get();
        } else {
            // Get all Paret translations
            $translations = KoranUebersetzung::where('sprache', 'de')->get();
        }


        $sprachen =[
            'de',
            'en_pickthall',
            'fr_hamidullah',
            'nl_leemhuis',
            'bs_korkut',
            'de_bubenheim',
            'en_arberry',
            'tr_ozturk',
            'tr_diyanet'
        ];


        return view("druckausgabe.index", compact("sure", "sprache", "sprachen", "translations"));
    }

    /**
     * Display a listing of the resource by a certain language.
     *
     * @param string $sprache
     * @return \Illuminate\Http\Response
     */
    public function indexSprache($sprache)
    {
        $translations = KoranUebersetzung::where('sprache', $sprache)->get();
        $sprachen =[
            'de',
            'en_pickthall',
            'fr_hamidullah',
            'nl_leemhuis',
            'bs_korkut',
            'de_bubenheim',
            'en_arberry',
            'tr_ozturk',
            'tr_diyanet'
        ];
        $sure = null;
        return view("druckausgabe.index", compact("sure", "sprache", "sprachen", "translations"));

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
     * @param  int  $sure
     * @param  int  $vers
     * @return \Illuminate\Http\Response
     */
    public function showByVerse($sure, $vers)
    {
        $translations = KoranUebersetzung::where('sure', $sure)->where('vers', $vers)->get();

        return view("druckausgabe.show", compact("translations"));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $sure
     * @param  int  $vers
     * @return \Illuminate\Http\Response
     */
    public function editByVerse($sure, $vers)
    {
        $translations = KoranUebersetzung::where('sure', $sure)->where('vers', $vers)->get();

        return view("druckausgabe.edit", compact("translations", "actions"));
    }


    /**
     * Update the specified resource in storage by a certain language.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $sure
     * @param  int  $vers
     * @param  string  $sprache
     * @return \Illuminate\Http\Response
     */
    public function updateBySprache($request, $sure, $vers, $sprache)
    {
        $translation = KoranUebersetzung::where(
            ['sprache' => $sprache,
                'sure' => $sure,
                 'vers'=> $vers
            ])->first();

        $name = $sprache . '_text';
        $translation->text = $request->$name;

        $translation->save();

    }

    /**
     * Update the specified resource in storage by a certain language.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $sure
     * @param  int  $vers
     * @return \Illuminate\Http\Response
     */
    public function updateByVerse(Request $request, $sure, $vers)
    {
        // validation
        $translations = KoranUebersetzung::where('sure', $sure)->where('vers', $vers)->get();
        $sprachen = $translations->pluck('sprache');
        $spracheValidation = [];

        foreach ($sprachen as $sprache) {
            $spracheValidation[$sprache . '_text'] = 'required' ;
        }
        $this->validate($request, $spracheValidation);

        // updating
        foreach ($sprachen as $sprache) {
            $this->updateBySprache($request, $sure, $vers, $sprache);
        }

        return redirect()->action([DruckausgabeController::class, 'showByVerse'], [$sure, $vers]);
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
