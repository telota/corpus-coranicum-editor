<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ZoteroBibliography;
use App\Models\Umwelttexte\Belegstelle as InterTexts;

/**
 * Controller for reformatting translations labels in ccdb.
 * Class TranslationController
 * @package App\Http\Controllers
 */
class TranslationController extends Controller
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

        $translations = Translation::all();

        return view("translation.index", compact("translations"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zotero = ZoteroBibliography::select('zotero_key', 'citation', 'short_citation')->where('citation', '!=', '')->orderby('citation', 'asc')->get()
            ->map(function ($value) {
                return [
                    'zotero_key' => $value->zotero_key,
                    'citation' =>  html_entity_decode($value->citation),
                    'short_citation' =>  html_entity_decode($value->short_citation),
                ];
            });
        $intertexts = Intertexts::select('id', 'titel')->where('titel', '!=', '')->orderby('id', 'asc')->get()
            ->map(function ($value) {
                return [
                    'id' => str_pad($value->id, 5, "0", STR_PAD_LEFT),
                    'titel' =>  html_entity_decode($value->titel),
                ];
            });
        return view("translation.create", compact("zotero", "intertexts"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            "key" => "required|translation_key",
            "deutsch" => "required|strip_tags_empty"
        ]);


        $translation = new Translation();

        $translation_key = strtolower(trim(str_replace(" ", "_", $request["key"])));

        $translation["key"] = $translation_key;
        $translation["de"] = ($request->deutsch) ?? "";
        $translation["en"] = ($request->englisch) ?? "";
        $translation["fr"] = ($request->französisch) ?? "";
        $translation["ar"] = ($request->arabisch) ?? "";
        $translation["fa"] = ($request->persisch) ?? "";
        $translation["ru"] = ($request->russisch) ?? "";
        $translation["tr"] = ($request->türksich) ?? "";
        $translation["ur"] = "";
        $translation["ind"] = "";
        $translation["user_id"] = Auth::user()->id;

        $translation->save();

        return redirect()->action([TranslationController::class, 'show'], $translation_key);
    }

    /**
     * Display the specified resource.
     *
     * @param int $key
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {
        $translation = Translation::find($key);
        return view("translation.show", compact("translation"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $key
     * @return \Illuminate\Http\Response
     */
    public function edit($key)
    {
        $translation = Translation::find($key);
        $zotero = ZoteroBibliography::select('zotero_key', 'citation', 'short_citation')->where('citation', '!=', '')->orderby('citation', 'asc')->get()
            ->map(function ($value) {
                return [
                    'zotero_key' => $value->zotero_key,
                    'citation' =>  html_entity_decode($value->citation),
                    'short_citation' =>  html_entity_decode($value->short_citation),
                ];
            });
        $intertexts = Intertexts::select('id', 'titel')->where('titel', '!=', '')->orderby('id', 'asc')->get()
            ->map(function ($value) {
                return [
                    'id' => str_pad($value->id, 5, "0", STR_PAD_LEFT),
                    'titel' =>  html_entity_decode($value->titel),
                ];
            });
        return view("translation.update", compact("translation", "zotero", "intertexts"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $key
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key)
    {
        $this->validate($request, [
            "deutsch" => "required|strip_tags_empty"
        ]);

        $translation = Translation::find($key);

        $translation["de"] = ($request->deutsch) ?? "";
        $translation["en"] = ($request->englisch) ?? "";
        $translation["fr"] = ($request->französisch) ?? "";
        $translation["ar"] = ($request->arabisch) ?? "";
        $translation["fa"] = ($request->persisch) ?? "";
        $translation["ru"] = ($request->russisch) ?? "";
        $translation["tr"] = ($request->türkisch) ?? "";
        $translation["ur"] = "";
        $translation["ind"] = "";
        $translation["user_id"] = Auth::user()->id;

        $translation->save();

        return redirect()->action([TranslationController::class, 'show'], [$translation->key]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Export the translation data into csv
     *
     * @param $lang
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export($lang)
    {

        // Initialize Content string
        $content = "";

        // Get all translation entries
        $translations = Translation::all();

        // Return to index page if language is not supported
        if (!(in_array($lang, array("de", "en", "fr")))) {
            Session::flash("flash_message", "Ungültige Sprache");
            Session::flash("flash_type", "alert-danger");

            return redirect()->action([TranslationController::class, 'index']);
        }

        // Iterate over translation files
        foreach ($translations as $translation) {
            $translationString = $translation[$lang];
            $translationString = str_replace('"', "'", $translationString);

            // Create a line string
            $line = "";
            $line .= $translation->key . ";";
            $line .= '"' . $translationString . '"';

            // Append line to content
            $content .= $line . "\n";
        }

        // Generate temporary file
        $filename = Str::random() . ".csv";
        Storage::put($filename, $content);

        // Return file download and delete temporary file afterwards
        return response()->download(storage_path() . "/app/" . $filename, $lang . ".csv")
            ->deleteFileAfterSend(true);
    }
}
