<?php

namespace App\Http\Controllers;

use App\Events\UpdateCodexIlluminationEvent;
use App\Models\ImageDetail;
use App\Models\Koranstelle;
use App\Models\Manuskripte\Manuskript;
use App\Models\Manuskripte\Manuskriptseiten;
use App\Models\Sure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AjaxController extends Controller
{

    /**
     * Only allow access when logged in
     */
    public function __construct()
    {
        //$this->middleware('auth');

        if (env("APP_ENV") != "local") {
            $this->middleware('auth.basic');
        }
    }

    /**
     * @param Request $request
     * @return array
     * @internal param $sure
     */
    public function createVersSelect(Request $request)
    {
        $sure = $request->get("sure");
        $vers = $request->get("vers");
        $domId = $request->get("domId");

        $versId = "";
        if ($domId == "sure_s") {
            $versId = "vers_s";
        } elseif ($domId == "sure_e") {
            $versId = "vers_e";
        } elseif ($domId == "sure") {
            $versId = "vers";
        }

        $maxVers = Sure::getMaxVers($sure);

        $selectForm = view("includes.basic_forms.select", [
            "label"   => $versId,
            "options" => array_combine(range(0, $maxVers), range(0, $maxVers)),
            "default" => $vers
        ])->render();

        return response()->json(array(
            "selectForm" => $selectForm,
            "versId"     => $versId
        ))->setCallback($request->input('callback'));
    }

    /**
     * Adds an additional Textstelle field on the manuskriptseiten
     * create/edit pages.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function addTextstelleInput(Request $request)
    {
        $counter = $request->get("counter");

        $textstelleView = "includes.textstellen.textstellekoran-min-sure-vers-wort";

        if (str_contains($request->server("HTTP_REFERER"), "umwelttexte")) {
            $textstelleView = "includes.textstellen.textstellekoran-min-sure-vers";
        }

        $selectForm = view($textstelleView, [
            "counter" => $counter
        ])->render();

        return response()->json(array(
            "selectForm" => $selectForm,
            "tester"     => $request->getRequestUri()
        ))->setCallback($request->input("callback"));
    }

    /**
     * Adds an additional leser select field to the lesearten
     * create/edit views.
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function addLeserInput(Request $request)
    {
        $counter = $request->get("counter");

        $selectForm = view("includes.leseart.leserSelect", [
            "counter" => $counter,
            "default" => null
        ])->render();

        return response()->json(array(
            "selectForm" => $selectForm
        ))->setCallback($request->input("callback"));
    }

    /**
     * Generate an input view to add images for TUKs
     *
     * @param Request $request
     * @return mixed
     */
    public function addImageInput(Request $request)
    {
        $counter = $request->get("counter");
        $route = $request->get("route");

        $inputForm = view("includes.{$route}.images-add", [
            "counter" => $counter + 1
        ])->render();

        return response()->json(array(
            "inputForm" => $inputForm
        ))->setCallback($request->input("callback"));
    }

    /**
     * Generate an input view for Leser aliases
     *
     * @param Request $request
     *
     * @return $this
     */
    public function addAliasInput(Request $request)
    {
        $counter = $request->get("counter");

        $inputForm = view("includes.leser.alias-add", [
            "counter" => $counter
        ])->render();

        return response()->json(array(
            "inputForm" => $inputForm
        ))->setCallback($request->input("callback"));
    }

    /**
     * Generate new variant inputs depending on sura and vers
     *
     * @param Request $request
     *
     * @return $this
     */
    public function changeVariantenInput(Request $request, $sura, $verse)
    {
        $maxWort = Sure::getMaxWort($sura, $verse);

        $words = Koranstelle::getVers($sura, $verse);

        return view("includes.leseart.varianten", [
            "maxWort" => $maxWort,
            "words"   => $words
        ])->render();
    }

    /**
     * Generate the Paret translation and get the transliterations
     * for all selected verses
     *
     * @param Request $request
     *
     * @return $this
     */
    public function getParetTransliteration(Request $request)
    {


        // Read textstellen json
        $textstellen = json_decode($request->get("texstellen"), true);



        // Array to store all valid Koranstellen
        $koranstellenGroups = array();

        // Iterate over koranstellen
        foreach ($textstellen as $i => $textstelle) {
            $koranstellenGroups[$i] = array();

            // Initialize starting sura and vers
            $koranstelle = new Koranstelle();
            $koranstelle->sure = $textstelle["sure_s"];
            $koranstelle->vers = $textstelle["vers_s"];

            $endstelle = new Koranstelle();
            $endstelle->sure = $textstelle["sure_e"];
            $endstelle->vers = $textstelle["vers_e"];

            $hasNext = true;

            // Iterate until start and end are the same
            while ($hasNext) {
                // Push current Koranstelle to the respective array
                array_push($koranstellenGroups[$i], $koranstelle);

                $hasNext = !(
                    ($koranstelle->sure == $endstelle->sure) &&
                    ($koranstelle->vers == $endstelle->vers)
                );

                $koranstelle = $koranstelle->getNextVerse();
            }

            Log::info($koranstellenGroups);

            $koranstellenView = view("includes.koranstellen.koranstellen", [
                "koranstellenGroups" => $koranstellenGroups
            ])->render();
        }


        return response()->json(array(
            "koranstellenView" => $koranstellenView,
        ))->setCallback($request->input("callback"));
    }

    /**
     * Get a list of words for a given verse
     *
     * @param Request $request
     * @return $this
     */
    public function getWordsWithArabicAndTranscription(Request $request)
    {
        $sure = $request->get("sure");
        $vers = $request->get("vers");

        $words = Koranstelle::getVers($sure, $vers);

        $options = array();

        $nullOption = "<option value='0' arab=''>0</option>";
        array_push($options, $nullOption);

        foreach ($words as $word) {
            $option = "<option value='{$word->wort}' arab='{$word->arab}' " .
            "class='arab-option'>{$word->wort} ({$word->transkription})</option>";
            array_push($options, $option);
        }

        return response()->json(array(
            "words" => $options
        ))->setCallback($request->input("callback"));
    }


    public function getAllKoranstellen(Request $request)
    {
        $koranstellen = Koranstelle::getAllKoranstellenGrouped();

        return response()->json(array(
            "koranstellen" => $koranstellen
        ))->setCallback($request->input("callback"));
    }

    /**
     * Get all Manuscripts as JSON
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getManuscriptList()
    {
        $manuscripts = Manuskript::get(["Kodextitel", "ID", "TextstelleKoran"])
            ->sortBy("ID");

        return response()->json(
            $manuscripts
        );
    }

    public function getManuscriptInfo(Request $request)
    {
        $manuscriptId = $request->get("manuscriptId");

        return response()->json(Manuskript::find($manuscriptId)->allFolios);
    }

    public function getVerse(Request $request)
    {
        $maxVers = Koranstelle::where("sure", $request->sure)
            ->max("vers");

        $verses = range(1, $maxVers);

        return response()->json($verses);
    }

    public function getWords(Request $request)
    {
        $words = Koranstelle::where("sure", $request->sure)
            ->where("vers", $request->vers)
            ->orderBy("wort")
            ->get(["wort", "transkription", "arab"]);

        return response()->json($words);
    }
}
