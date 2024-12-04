<?php

namespace App\Http\Controllers;

use App\Events\UpdateIntertextEvent;
use App\Models\Intertexts\Intertext;
use App\Models\Intertexts\IntertextCategory;
use App\Models\Intertexts\IntertextIllustration;
use App\Models\Intertexts\IntertextMapping;
use App\Models\Intertexts\OriginalLanguage;
use App\Models\Intertexts\Script;
use App\Models\Umwelttexte\Belegstelle;
use App\Models\Umwelttexte\BelegstellenBilder;
use App\Models\Umwelttexte\BelegstellenKategorie;
use App\Models\Umwelttexte\BelegstellenMapping;
use App\Models\Helpers\ZoteroHelper;
use App\Models\Sure;
use App\Listeners\UpdateIntertextAuthors;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Yaml\Tests\B;

class IntertextController extends Controller
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
            "intertexts-index",
            Carbon::now()->addMinutes(15),
            function () {
                return view("intertexts.index", ["intertexts" => Intertext::all()])->render();
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
        $sure = intval($sure);
        $intertexts = Intertext::all();

        $intertextSure = array();

        $quranTexts = array();

        foreach ($intertexts as $intertext) {
            $texts = $intertext->quranTexts;

            foreach ($texts as $text) {
                if ($sure >= $text->sure_start && $sure <= $text->sure_end) {


                    array_push($intertextSure, $intertext);
                    if (!(array_key_exists($intertext->id, $quranTexts))) {
                        $quranTexts[$intertext->id] = array();
                    }

                    $position = str_pad($text->sure_start, 3, 0, STR_PAD_LEFT) . ":" .
                        str_pad($text->vers_start, 3, 0, STR_PAD_LEFT);

                    if (!($text->sure_start == $text->sure_end &&
                        $text->vers_start == $text->vers_end)) {
                        $position .= "-" . str_pad($text->sure_end, 3, 0, STR_PAD_LEFT) . ":" .
                            str_pad($text->vers_end, 3, 0, STR_PAD_LEFT);
                    }

                    array_push($quranTexts[$intertext->id], $position);
                }
            }
        }

        $intertextSure = array_unique($intertextSure);
        $maxVers = Sure::getMaxVers($sure);

        return view("intertexts.index")
            ->with("intertexts", $intertextSure)
            ->with("sure", $sure)
            ->with("maxVers", $maxVers)
            ->with("quranTexts", $quranTexts);
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
        $sure = intval($sure);
        $vers = intval($vers);

        $intertexts = Intertext::all();

        $intertextVers = array();
        foreach ($intertexts as $intertext) {
            foreach ($intertext->quranTexts as $quranText) {
                if (($sure >= $quranText->sure_start && $sure <= $quranText->sure_end) &&
                    ($vers >= $quranText->vers_start && $vers <= $quranText->vers_end)) {
                    array_push($intertextVers, $intertext);
                }
            }
        }
        $intertextVers = array_unique($intertextVers);

        $maxVers = Sure::getMaxVers($sure);

        return view("intertexts.index")
            ->with("intertexts", $intertextVers)
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
        $intertexts = Intertext::where("language_id", $lang)->get();

        return view("intertexts.index")
            ->with("intertexts", $intertexts)
            ->with("lang", $lang);
    }

    /**
     * List all Umwelttexte for a given category
     * @param $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function indexCategory($categoryId)
    {
        $intertexts = Intertext::where("category_id", $categoryId)->get();

        return view("intertexts.index")
            ->with("intertexts", $intertexts)
            ->with("categoryId", $categoryId);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Create new Umwelttext
        $intertext = new Intertext();

        $columns = Schema::getColumnListing("it_intertext");

        foreach ($columns as $column) {
            $intertext[$column] = "";

            if ($column == "created_at" || $column == "updated_at") {
                $intertext[$column] = new Carbon();
            }
        }

        $intertext->images = [];

        $action = ['App\Http\Controllers\IntertextController@store'];

        return view("intertexts.create", compact("intertext", "action"));
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
            "source_id" => "required",
//            "source_chapter" => "required",
            "category_id" => "required",
            "entry" => "required",
            "sure_s" => 'required|textstellen_gt'
        ]);

        // Update Umwelttext
        $umwelttext = $this->createUpdate($request);

        return redirect()->action([IntertextController::class, 'show'], $umwelttext->id);
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
        $intertext = Intertext::find($id);

        $intertext->source_text_original = urldecode($intertext->source_text_original);
//        if ($intertext->category_id) {
//            $intertext->category_id = $intertext->fullCategoryName;
//        }

        $koranstellenChrono = Intertext::find($id)->koranstellenChronologyString();

        return view("intertexts.show", compact("intertext", "koranstellenChrono"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $intertext = Intertext::find($id);

        $intertext->images = Intertext::find($id)->images;

        $intertext->source_text_original = urldecode($intertext->source_text_original);

        $action = array('App\Http\Controllers\IntertextController@update', $id);

        $allowFileUpload = true;

        return view("intertexts.edit", compact("intertext", "action", "allowFileUpload"));
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
            "source_id" => "required",
            "category_id" => "required",
            "entry" => "required",
            "sure_s" => 'required|textstellen_gt',
        ]);

        // Update Umwelttext
        $intertext = $this->createUpdate($request, $id);

        return redirect()->action([IntertextController::class, 'show'], $id);
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
        $intertext = new Intertext();
        if (!empty($id)) {
            $intertext = Intertext::find($id);
        }

        if (intval($request->is_online) > 0 && $intertext->is_online < 1)
            $intertext->published_at = new Carbon();

        // Iterate over the request
        foreach ($request->except(["_token", "quran_text", "id", "sure_s",
            "sure_e", "vers_s", "vers_e", "wort_s", "wort_e", "files",
            "authors", "collaborators", "updaters", "text_editing",
            "images", "existing_images", "licence_for_image", "bildlinknachweis", "bildlink_extern",
            "source_text_original", "original_language", "script_language", "quran_texts"]) as $parameter => $content) {
            $intertext[$parameter] = $content;
        }

        if (!empty($id)) event(new UpdateIntertextEvent($request, $id));

        if (!$intertext->created_by)
        $intertext->created_by = Auth::user()->name;

        $intertext->updated_by = Auth::user()->name;

        $intertext->updated_at = Carbon::now();

        $intertext->source_text_original = $request->source_text_original;

        if ($request->original_language == "None"){
            $intertext->language_id = null;
        } else {
            $intertext->language_id = OriginalLanguage::where("original_language",$request->original_language)->first()->id;
        }

        if ($request->script_language == "None") {
            $intertext->script_id = null;
        } else {
            $intertext->script_id = Script::where("script", $request->script_language)->first()->id;
        }

//        $umwelttext->Literatur = ZoteroHelper::extractZotero($request);

        // Save Umwelttext in order to assign an ID (if not yet created)
        $intertext->save();

        $quranTexts = self::createUpdateKoranstellen($request, $intertext);
        $intertext->quran_text = $quranTexts;

        // Save again to save the textstellen parameter
        $intertext->save();

        self::updateImages($request, $intertext->id, $intertext->images->pluck("id"));
        return $intertext;
    }

    /**
     * Create or update the sura/vers mappings
     *
     * @param Request $request
     * @param $intertext
     * @return string
     */
    private static function createUpdateKoranstellen(Request $request, $intertext)
    {
        // Get previous mappings
        $quranTexts = $intertext->quranTexts;

        // Delete all of them, in order to recrate them later on again
        foreach ($quranTexts as $quranText) {
            $quranText->delete();
        }

        $quranTextString = "";


        // Iterate over all new quran texts in the request variable
        for ($i = 0; $i < count($request->sure_s); $i++) {

            $quranText = new IntertextMapping();
            $quranText->intertext_id = $intertext->id;
            $quranText->sure_start = $request->sure_s[$i];
            $quranText->vers_start = $request->vers_s[$i];
            $quranText->sure_end = $request->sure_e[$i];
            $quranText->vers_end = $request->vers_e[$i];
            $quranText->save();

            // Create string of quran texts
            $quranTextString .=
                str_pad($request->sure_s[$i], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($request->vers_s[$i], 3, 0, STR_PAD_LEFT) . "-" .
                str_pad($request->sure_e[$i], 3, 0, STR_PAD_LEFT) . ":" .
                str_pad($request->vers_e[$i], 3, 0, STR_PAD_LEFT);

            if (($i + 1) < count($request->sure_s)) {
                $quranTextString .= ";";
            }

        }

        // Arrange quran text in ascending order
        $quranTextSort = explode(";", $quranTextString);
        natsort($quranTextSort);
        $quranTextString = implode(";", $quranTextSort);

        return $quranTextString;
    }

    /**
     * @param Request $request
     * @param $images Eloquent relation: Images of umwelttext
     */
    private static function updateImages(Request $request, $intertextId, $imageIds) //TODO
    {
        $licenceForImageIndex = 0;
        $intertextsDir =  "./storage/app/test/Umwelttexte";


        if ($request->has("existing_images")) {
            $existingImages = $request->existing_images;
            $intertextImages = Intertext::find($intertextId)->images;

            foreach ($intertextImages as $intertextImage) {
                if (!in_array($intertextImage->id, $existingImages)) {
                    $removeImage = IntertextIllustration::find($intertextImage->id);
                    $removeImage->delete();
                } else {
                    $intertextImage->licence_for_image = $request->licence_for_image[$licenceForImageIndex];
                    $intertextImage->save();
                    $licenceForImageIndex++;
                }
            }
        } else {
            // If request has no existing images, delete all pre-existing ones

            $intertextImages = Intertext::find($intertextId)->images;

            foreach ($intertextImages as $intertextImage) {
                $intertextImage->delete();
            }
        }

        $imageFiles = $request->file("images");
        if ($imageFiles == null) $imageFiles = array();

        if (count($imageFiles) > 0) {
            // Now upload all new images
            foreach ($imageFiles as $imageIndex => $imageFile) {
                $image = new IntertextIllustration();
                $image->intertext_id = $intertextId;
                $image->image_link = "Umwelttexte/" . $imageFile->getClientOriginalName();
                $image->licence_for_image = $request->licence_for_image[$licenceForImageIndex];
                $imageName = $imageFile->getClientOriginalName();

                // Check whether there is already a file with the same name
                $imageNames = IntertextIllustration::where("image_link", $image->image_link)->count();
                if ($imageNames > 0) {
                    $imageName = explode(".", $imageFile->getClientOriginalName())[0];
                    $imageName .= "_" . str_random(6) . "." . $imageFile->getClientOriginalExtension();
                    $image->image_link = "Umwelttexte/" . $imageName;
                    $image->licence_for_image = $request->licence_for_image[$licenceForImageIndex];
                }
                $licenceForImageIndex++;

                $image->save();

                $imageFile->move($intertextsDir, $imageName); //TODO
                dd($imageFile);
            }
        }
    }
}
