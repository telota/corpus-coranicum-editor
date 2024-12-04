<?php

namespace App\Http\Controllers;

use App\Models\Umwelttexte\Belegstelle;
use App\Models\Umwelttexte\Belegstelle as InterTexts;
use App\Models\Umwelttexte\BelegstellenBilder;
use App\Models\Umwelttexte\BelegstellenKategorie;
use App\Models\Umwelttexte\BelegstellenMapping;
use App\Models\Helpers\ZoteroHelper;
use App\Models\Sure;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Tests\B;
use App\Models\ZoteroBibliography;

class UmwelttexteController extends Controller
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
        $view = Cache::remember(
            "umwelttexte-index",
            Carbon::now()->addMinutes(15),
            function () {
                return view("umwelttexte.index", ["umwelttexte" => Belegstelle::all()])->render();
            }
        );

        return $view;
    }

    /**
     * Display all umwelttexte of a specific sura
     * @param $sure
     * @return
     */
    public function indexSure($sure)
    {

        $umwelttexte = Belegstelle::all();

        $umwelttexteSure = array();

        $textstellen = array();

        foreach ($umwelttexte as $umwelttext) {
            $koranstellen = $umwelttext->koranstellen;

            foreach ($koranstellen as $koranstelle) {
                if ($sure >= $koranstelle->sure_start && $sure <= $koranstelle->sure_ende) {
                    array_push($umwelttexteSure, $umwelttext);
                    if (!(array_key_exists($umwelttext->ID, $textstellen))) {
                        $textstellen[$umwelttext->ID] = array();
                    }

                    $stelle = str_pad($koranstelle->sure_start, 3, 0, STR_PAD_LEFT) . ":" .
                        str_pad($koranstelle->vers_start, 3, 0, STR_PAD_LEFT);

                    if (!($koranstelle->sure_start == $koranstelle->sure_ende &&
                        $koranstelle->vers_start == $koranstelle->vers_ende)) {
                        $stelle .= "-" . str_pad($koranstelle->sure_ende, 3, 0, STR_PAD_LEFT) . ":" .
                            str_pad($koranstelle->vers_ende, 3, 0, STR_PAD_LEFT);
                    }

                    array_push($textstellen[$umwelttext->ID], $stelle);
                }
            }
        }

        $umwelttexteSure = array_unique($umwelttexteSure);

        $maxVers = Sure::getMaxVers($sure);

        return view("umwelttexte.index")
            ->with("umwelttexte", $umwelttexteSure)
            ->with("sure", $sure)
            ->with("maxVers", $maxVers)
            ->with("textstellen", $textstellen);
    }

    /**
     * List all Umwelttexte for a specific vers
     *
     * @param $sure
     * @param $vers
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexVers($sure, $vers)
    {
        $umwelttexte = Belegstelle::all();

        $umwelttexteVers = array();
        foreach ($umwelttexte as $umwelttext) {
            foreach ($umwelttext->koranstellen as $koranstelle) {
                if (($sure >= $koranstelle->sure_start && $sure <= $koranstelle->sure_ende) &&
                    ($vers >= $koranstelle->vers_start && $vers <= $koranstelle->vers_ende)
                ) {
                    array_push($umwelttexteVers, $umwelttext);
                }
            }
        }
        $umwelttexteVers = array_unique($umwelttexteVers);

        $maxVers = Sure::getMaxVers($sure);

        return view("umwelttexte.index")
            ->with("umwelttexte", $umwelttexteVers)
            ->with("sure", $sure)
            ->with("vers", $vers)
            ->with("maxVers", $maxVers);
    }

    /**
     * List all Umwelttexte for a given language
     * @param $lang
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function indexLanguage($lang)
    {

        $lang = urldecode($lang);

        if (!(Belegstelle::getAllLanguages()->contains($lang))) {
            Session::flash("flash_type", "alert-danger");
            Session::flash("flash_message", "Invalid language: " . $lang);

            return back()->withInput();
        }

        $umwelttexte = Belegstelle::where("Sprache", "LIKE", "%" . $lang . "%")->get();

        return view("umwelttexte.index")
            ->with("umwelttexte", $umwelttexte)
            ->with("lang", $lang);
    }

    /**
     * List all Umwelttexte for a given category
     * @param $kategorie
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function indexKategorie($kategorie)
    {
        $umwelttexte = [];
        if (strlen($kategorie) < 2) {
            $kategorieIds = BelegstellenKategorie::all()->pluck('id');
            $count = 0;
            foreach ($kategorieIds as $kategorieId) {
                if (str_starts_with($kategorieId, $kategorie)) {
                    $kategorie1 = Belegstelle::where("kategorie", "LIKE", $kategorieId)->get();
                    foreach ($kategorie1 as $kate) {
                        $umwelttexte[$count++] = $kate;
                    }
                }
            }
        } else {
            $umwelttexte = Belegstelle::where("kategorie", "LIKE", $kategorie)->get();
        }

        return view("umwelttexte.index")
            ->with("umwelttexte", $umwelttexte)
            ->with("kategorie", $kategorie);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Create new Umwelttext
        $umwelttext = new Belegstelle();

        $columns = Schema::getColumnListing("belegstellen");

        foreach ($columns as $column) {
            $umwelttext[$column] = "";

            if ($column == "created_at" || $column == "updated_at") {
                $umwelttext[$column] = new Carbon();
            }
        }

        $action = ['App\Http\Controllers\UmwelttexteController@store'];
        $zotero = ZoteroBibliography::forSummernote();
        $intertexts = Belegstelle::forSummernote();


        return view("umwelttexte.create_update", compact("umwelttext", "action", "zotero", "intertexts"));
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
            "Titel" => "required",
            "Sprache" => "required",
            "Ort" => "required",
            "kategorie" => "required",
            "sura_start" => 'required|textstellen_gt',
        ]);

        // Update Umwelttext
        $umwelttext = $this->createUpdate($request);

        return redirect()->action([UmwelttexteController::class, 'show'], $umwelttext->ID);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get Umwelttext
        $umwelttext = Belegstelle::find($id);

        $umwelttext->Originalsprache = urldecode($umwelttext->Originalsprache);
        if ($umwelttext->kategorie) {
            $umwelttext->kategorie = $umwelttext->fullCategoryName;
        }

        $koranstellenChrono = Belegstelle::find($id)->koranstellenChronologyString();

        return view("umwelttexte.show", compact("umwelttext", "koranstellenChrono"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $umwelttext = Belegstelle::find($id);

        $umwelttext->images = Belegstelle::find($id)->images;

        $umwelttext->Originalsprache = urldecode($umwelttext->Originalsprache);

        $action = array('App\Http\Controllers\UmwelttexteController@update', $id);

        $allowFileUpload = true;
        $zotero = ZoteroBibliography::forSummernote();
        $intertexts = Belegstelle::forSummernote();

        return view("umwelttexte.create_update", compact("umwelttext", "action", "allowFileUpload", "zotero", "intertexts"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            "Titel" => "required",
            "sura_start" => 'required|textstellen_gt',
        ]);

        // Update Umwelttext
        $umwelttext = $this->createUpdate($request, $id);

        return redirect()->action([UmwelttexteController::class, 'show'], $id);
    }

    /**
     * Method to create or update
     *
     * @param Request $request
     * @param null $id
     * @return Belegstelle
     */
    private static function createUpdate(Request $request, $id = null)
    {
        // Create or get Umwelttext
        $umwelttext = new Belegstelle();
        if (empty($id)) {
            //So that non-admins can create Umwelttexte
            $umwelttext['webtauglich'] = 'nein';
        }else{
            $umwelttext = Belegstelle::find($id);

        }


        // Iterate over the request
        foreach ($request->except([
            "_token", "TextstelleKoran", "ID", "sura_start",
            "sura_end", "verse_start", "verse_end", "files", "existing_images", "images",
            "bildnachweis", "Originalsprache"
        ]) as $parameter => $content) {
            $umwelttext[$parameter] = $content;
        }

        $umwelttext->lastAuthor = Auth::user()->name;

        $umwelttext->Originalsprache = $request->Originalsprache;
        $umwelttext->save();

        $umwelttext->Literatur = ZoteroHelper::extractZotero($request);

        // Save Umwelttext in order to assign an ID (if not yet created)
        $umwelttext->save();

        $textstelleKoran = self::createUpdateKoranstellen($request, $umwelttext);
        $umwelttext->TextstelleKoran = $textstelleKoran;
        // Save again to save the textstellen parameter
        $umwelttext->save();


        self::updateImages($request, $umwelttext->ID, $umwelttext->images->pluck("id"));
        return $umwelttext;
    }

    /**
     * Create or update the sura/vers mappings
     *
     * @param Request $request
     * @param $umwelttext
     * @return string
     */
    private static function createUpdateKoranstellen(Request $request, $umwelttext)
    {
        // Get previous mappings
        $koranstellen = $umwelttext->koranstellen;

        // Delete all of them, in order to recrate them later on again
        foreach ($koranstellen as $koranstelle) {
            $koranstelle->delete();
        }

        $koranstellenString = "";


        // Iterate over all new koranstellen in the request variable
        for ($i = 0; $i < count($request->sura_start); $i++) {

            $koranstelle = new BelegstellenMapping();
            $koranstelle->belegstelle = $umwelttext->ID;
            $koranstelle->sure_start = $request->sura_start[$i];
            $koranstelle->vers_start = $request->verse_start[$i];
            $koranstelle->sure_ende = $request->sura_end[$i];
            $koranstelle->vers_ende = $request->verse_end[$i];

            $koranstelle->save();

            // Create KoranstellenString
            $koranstellenString .=
                str_pad($request->sura_start[$i], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($request->verse_start[$i], 3, 0, STR_PAD_LEFT) . "-" .
                str_pad($request->sura_end[$i], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($request->verse_end[$i], 3, 0, STR_PAD_LEFT);

            if (($i + 1) < count($request->sura_start)) {
                $koranstellenString .= ";";
            }
        }

        // Arrange textstellen in ascending order
        $koranstellenSort = explode(";", $koranstellenString);
        natsort($koranstellenSort);
        $koranstellenString = implode(";", $koranstellenSort);

        return $koranstellenString;
    }

    /**
     * @param Request $request
     * @param $images Eloquent relation: Images of umwelttext
     */
    private static function updateImages(Request $request, $belegstellenId, $imageIds)
    {
        $bildnachweisIndex = 0;
        $umwelttexteDir = env("DIGILIB_MOUNTPOINT") . "Umwelttexte";

        if ($request->has("existing_images")) {
            $existingImages = $request->existing_images;

            $belegstellenBilder = Belegstelle::find($belegstellenId)->images;

            foreach ($belegstellenBilder as $belegstellenBild) {
                if (!in_array($belegstellenBild->id, $existingImages)) {
                    $removeImage = BelegstellenBilder::find($belegstellenBild->id);
                    $removeImage->delete();
                } else {
                    $belegstellenBild->bildnachweis = $request->bildnachweis[$bildnachweisIndex];
                    $belegstellenBild->save();
                    $bildnachweisIndex++;
                }
            }
        } else {
            // If request has no existing images, delete all pre-existing ones

            $belegstellenBilder = Belegstelle::find($belegstellenId)->imageS;

            foreach ($belegstellenBilder as $belegstellenBild) {
                $belegstellenBild->delete();
            }
        }

        $imageFiles = $request->file("images");

        if (isset($imageFiles) && count($imageFiles) > 0) {
            // Now upload all new images
            foreach ($imageFiles as $imageIndex => $imageFile) {
                $image = new BelegstellenBilder();
                $image->belegstelle = $belegstellenId;
                $image->bildlink = "Umwelttexte/" . $imageFile->getClientOriginalName();
                $image->bildnachweis = $request->bildnachweis[$bildnachweisIndex];
                $imageName = $imageFile->getClientOriginalName();

                // Check whether there is already a file with the same name
                $imageNames = BelegstellenBilder::where("bildlink", $image->bildlink)->count();
                if ($imageNames > 0) {
                    $imageName = explode(".", $imageFile->getClientOriginalName())[0];
                    $imageName .= "_" . str_random(6) . "." . $imageFile->getClientOriginalExtension();
                    $image->bildlink = "Umwelttexte/" . $imageName;
                    $image->bildnachweis = $request->bildnachweis[$bildnachweisIndex];
                }
                $bildnachweisIndex++;

                $image->save();

                $imageFile->move($umwelttexteDir, $imageName);
            }
        }
    }
}
