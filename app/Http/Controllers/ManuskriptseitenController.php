<?php

namespace App\Http\Controllers;

use App\Console\Commands\UpdateManuskriptMappings;
use App\Models\Koranstelle;
use App\Models\Transliteration;
use App\Listeners\Paleocoran\UpdateCodexMappings;
use App\Models\Manuskripte\Manuskript;
use App\Models\Manuskripte\ManuskriptMapping;
use App\Models\Manuskripte\Manuskriptseite;
use App\Models\Manuskripte\ManuskriptseitenBild;
use App\Models\Manuskripte\ManuskriptseitenMapping;
use App\Models\Paleocoran\Codex\Codex;
use App\Models\Sure;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class ManuskriptseitenController extends Controller
{

    /**
     * Only allow access when logged in
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get Manuskriptseite
        $manuskriptseite = Manuskriptseite::find($id);

        $manuskript = Manuskriptseite::find($id)->manuskript;

//        $transliterations = Transliteration::where("manuscript_page_id", $manuskriptseite->SeitenID)->get();

        return view("manuskriptseiten.show", compact("manuskriptseite", "manuskript"));
    }


    /**
     * Read Sura and Vers values from the Request object
     * and create TextstelleKoran string.
     *
     * @param Request $request
     *
     * @return string
     */
    private function extractTextstelle($mappings)
    {
        // Create new Textstelle
        $textstelleString = "";

        // Iterate over all textstellen supplied by the user
        for ($i = 0; $i < count($mappings); $i++) {
            $textstelleString .=
                str_pad($mappings[$i]["sure_start"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["vers_start"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["wort_start"], 3, 0, STR_PAD_LEFT) . "-" .
                str_pad($mappings[$i]["sure_ende"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["vers_ende"], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($mappings[$i]["wort_ende"], 3, 0, STR_PAD_LEFT);

            if (($i + 1) < count($mappings)) {
                $textstelleString .= ";";
            }
        }

        // Arrange textstellen in ascending order
        $textstelleSort = explode(";", $textstelleString);
        natsort($textstelleSort);
        $textstelleString = implode(";", $textstelleSort);

        return $textstelleString;
    }
}
