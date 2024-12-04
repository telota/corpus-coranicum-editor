<?php

namespace App\Http\Controllers;

use App\Events\UpdateManuskriptEvent;
use App\Models\Helpers\ZoteroHelper;
use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuscripts\ManuscriptOriginalCodex;
use App\Models\Manuscripts\ManuscriptPageImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\ZoteroBibliography;
use App\Models\Umwelttexte\Belegstelle as InterTexts;

use function PHPSTORM_META\map;

class ManuscriptNewController extends Controller
{

    /**
     * Only allow access when logged in
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private static function toDimensions($first, $second): string|null
    {
        if (isset($first) && isset($second)) {
            return "$first x $second";
        }
        return null;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(): View
    {
        return view("manuscript_new.index", ["manuskripte" => ManuscriptNew::with('place')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(): View
    {
        // Create new manuscript
        $manuskript = new ManuscriptNew();

        // Fetch attributes fo a manuscript
        $columns = Schema::getColumnListing('ms_manuscript');

        $action = ['App\Http\Controllers\ManuscriptNewController@store'];

        // Fill the manuscript objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at"))
                $manuskript[$column] = null;
        }
        $manuskript->writing_surface = 'Parchment';
        $zotero = ZoteroBibliography::select('zotero_key', 'citation', 'short_citation')->where('citation', '!=', '')->orderby('citation', 'asc')->get()
            ->map(function ($value) {
                return [
                    'zotero_key' => $value->zotero_key,
                    'citation' => html_entity_decode($value->citation),
                    'short_citation' => html_entity_decode($value->short_citation),
                ];
            });
        $intertexts = Intertexts::select('id', 'titel')->where('titel', '!=', '')->orderby('id', 'asc')->get()
            ->map(function ($value) {
                return [
                    'id' => str_pad($value->id, 5, "0", STR_PAD_LEFT),
                    'titel' => html_entity_decode($value->titel),
                ];
            });
        return view(
            "manuscript_new.create",
            compact("manuskript", "action", "zotero", "intertexts")
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate new manuscript
        $this->validate($request, [
            "call_number" => 'required',
            "place_id" => 'required',
        ]);

        //        $messages = [
        //            'place_id.unique' => 'Given call number and place id are not unique',
        //        ];
        //
        //        $callNumber = $request->call_number;
        //        $placeId = $request->place_id;
        //
        //        Validator::make($request, [
        //            'place_id' => [
        //                'required',
        //                Rule::unique('manuscript')->where(function ($query) use($callNumber,$placeId) {
        //                    return $query->where('place_id', $placeId)
        //                        ->where('call_number', $callNumber);
        //                }),
        //            ],
        //        ],
        //            $messages
        //        );

        $manuskript = $this->createUpdate($request);



        // Add flash messages
        Session::flash("flash_message", "Manuskript '{$manuskript->getName()}' wurde angelegt.");
        Session::flash("flash_type", "alert-success");

        return view("manuscript_new.show", compact("manuskript"));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($id): View
    {
        // Get Manuscript
        $manuskript = ManuscriptNew::with(['scriptStyles', 'images', 'manuscriptPages.mappings'])->findOrFail($id);

        return view("manuscript_new.show", compact("manuskript"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id1
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get Manusript
        $manuskript = ManuscriptNew::find($id);
        $zotero = ZoteroBibliography::select('zotero_key', 'citation', 'short_citation')->where('citation', '!=', '')->orderby('citation', 'asc')->get()
            ->map(function ($value) {
                return [
                    'zotero_key' => $value->zotero_key,
                    'citation' => html_entity_decode($value->citation),
                    'short_citation' => html_entity_decode($value->short_citation),
                ];
            });
        $intertexts = Intertexts::select('id', 'titel')->where('titel', '!=', '')->orderby('id', 'asc')->get()
            ->map(function ($value) {
                return [
                    'id' => str_pad($value->id, 5, "0", STR_PAD_LEFT),
                    'titel' => html_entity_decode($value->titel),
                ];
            });
        $action = array('App\Http\Controllers\ManuscriptNewController@update', $id);
        return view(
            "manuscript_new.edit",
            compact("manuskript", "action", "zotero", "intertexts")
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate manuscript to be updated

        $this->validate($request, [
            "call_number" => 'required',
            "place_id" => 'required',
        ]);

        $manuscript = $this->createUpdate($request, $id);


        Session::flash("flash_message", "Manuskript '" . $manuscript->getName() . "' aktualisiert");
        Session::flash("flash_type", "alert-info");

        return redirect()->action([ManuscriptNewController::class, 'show'], $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }

    private function createUpdate(Request $request, $id = null)
    {

        $manuscript = new ManuscriptNew();
        $manuscript->is_online = 0;
        $manuscript->no_images = 0;

        if (!empty($id)) {
            $manuscript = ManuscriptNew::find($id);
        }

        $form_fields = [
            "call_number",
            "catalogue_entry",
            "codicology",
            "commentary_internal",
            "credit_line_image",
            "date_start",
            "date_end",
            "doi",
            "number_of_folios",
            "ornaments",
            "paleography",
            "palimpsest_text",
            "place_id",
            "transliteration_file",
        ];

        GenericController::mapRequestToModel($request, $manuscript, $form_fields);

        if (!empty($id)) event(new UpdateManuskriptEvent($request, $id));

        //        COLOPHON DATE

        $colophonDateOption = collect($request->colophon_date_option)->values()[0];
        if ($colophonDateOption == "hijri") {
            $colophonHijriDateStart = collect($request->colophon_date_start_hijri)->values()[0];
            $colophonDateStart = ManuscriptNew::hijriToGregorianDate($colophonHijriDateStart);
            $manuscript->colophon_date_start = $colophonDateStart;

            $colophonHijriDateEnd = collect($request->colophon_date_end_hijri)->values()[0];
            $colophonDateEnd = ManuscriptNew::hijriToGregorianDate($colophonHijriDateEnd);
            $manuscript->colophon_date_end = $colophonDateEnd;
        } else {
            $manuscript->colophon_date_start = collect($request->colophon_date_start)->values()[0];
            $manuscript->colophon_date_end = collect($request->colophon_date_end)->values()[0];
        }
        //        dd($manuscript->date_end);

        //        COLOPHON TEXT

        $colophon = collect($request->colophon)->values()[0];


        if ($colophon == "no") {
            $manuscript->colophon_text = null;
            $manuscript->colophon_date_start = null;
            $manuscript->colophon_date_end = null;
        }


        //        PALIMPSEST TEXT

        $palimpsest = collect($request->palimpsest)->values()[0];


        if ($palimpsest == "no")
            $manuscript->palimpsest_text = null;


        //        SAJDA SIGNS TEXT

        $sajdaSigns = collect($request->sajda_signs)->values()[0];


        if ($sajdaSigns == "no")
            $manuscript->sajda_signs_text = null;


        //        SISTER LEAVES / ORIGINAL CODEX

        $originalCodexManuscript = collect($request->original_codex_manuscript)->values();
        $originalCodex = count($originalCodexManuscript) > 0 ? ManuscriptNew::find($originalCodexManuscript[0])->originalCodex : ManuscriptOriginalCodex::find(1)->first();
        $currentOriginalCodexId = $request->original_codex_id;


        if ($currentOriginalCodexId != $manuscript->original_codex_id)
            $manuscript->original_codex_id = $currentOriginalCodexId;
        elseif ($originalCodex) $manuscript->original_codex_id = $originalCodex->id;
        else $manuscript->original_codex_id = $currentOriginalCodexId;


        if ($manuscript->original_codex_id === "0") {
            $manuscript->original_codex_id = null;
        }

        //        WRITING SURFACE


        if ($request->writing_surface == 'Other') {
            $manuscript->writing_surface = $request->writing_surface_other;
        } else {
            $manuscript->writing_surface = $request->writing_surface;
        }

        //        CARBON DATING

        if (isset($request->c_dating_four)) {
            $cdatingFour = collect($request->c_dating_four)->values()[0];
        }

        if (isset($request->c_dating_two)) {
            $cdatingTwo = collect($request->c_dating_two)->values()[0];
        }

        if (isset($cdatingTwo) && isset($cdatingFour)) {
            $manuscript->carbon_dating = implode(".", [$cdatingFour, $cdatingTwo]);
        } else {
            $manuscript->carbon_dating = "";
        }


        //        DIMENSIONS
        $manuscript->dimensions = self::toDimensions(
            $request->dimensions_outer_max_width,
            $request->dimensions_outer_max_height,
        );


        $manuscript->format_text_field = self::toDimensions(
            $request->dimensions_inner_min_width,
            $request->dimensions_inner_min_height,
        );


        //        NUMBER OF LINES
        if (isset($request->max_number_lines) && isset($request->min_number_lines)) {
            $manuscript->number_of_lines =
                $request->min_number_lines .
                " - " .
                $request->max_number_lines;
        } else {
            $manuscript->number_of_lines = null;
        }

        $manuscript->save();
        $manuscript->attributedTo()->sync($request->attributed_to);
        $manuscript->authors()->sync($request->authors);
        $manuscript->diacritics()->sync($request->diacritics);
        $manuscript->funders()->sync($request->funders);
        $manuscript->provenances()->sync($request->provenances);
        $manuscript->readingSigns()->sync($request->reading_signs);
        $manuscript->rwtProvenances()->sync($request->rwt_provenances);
        $manuscript->scriptStyles()->sync($request->script_styles);
        $manuscript->verseSegmentations()->sync($request->verse_segmentations);

        return $manuscript;
    }

    /**
     * Generate the paleocoran XML manuscript files
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function paleocoranXmlExport($id)
    {

        // Get the manuscript
        $manuskript = ManuscriptNew::find($id);

        $zipPath = $manuskript->generatePaleocoranXml();

        Storage::deleteDirectory("paleocoran/tmp/");

        // Return file download and delete temporary file afterwards
        return response()->download($zipPath)
            ->deleteFileAfterSend(true);
    }

    private function checkForProtectedManuscript($id){
        $protectedManuscripts = array(
            12, 19, 52, 117, 151, 152, 165, 173, 323, 331, 332,
            333, 391, 392, 393, 394, 395, 396, 397, 398, 399, 400, 401,
            402, 403, 404, 405, 406, 407, 408, 409, 410, 508,
            519, 520, 544, 545, 546, 547,
        );

        if (in_array($id, $protectedManuscripts)) {
            abort(403, "Manuscript $id is a protected manuscript and it's publishing and image status cannot be changed.");
        }

    }
    public function publish(Request $request)
    {
        $id = $request->manuscript_id;
        $this->checkForProtectedManuscript($id);
        $is_online = $request->boolean('is_online');
        $manuscript = ManuscriptNew::findOrFail($id);
        $is_online ? $manuscript->is_online = 1 : $manuscript->is_online = 0;
        $manuscript->save();

        return redirect()->action([ManuscriptNewController::class, 'show'], $manuscript->id);
    }

    public function restrictImages(int $id)
    {
        $manuscript = ManuscriptNew::with('images')->findOrFail($id);
        foreach($manuscript->images as $image){
            if(!$image->private_use_only){
                abort(403, 'All images must be set to private before images can be restricted on the manuscript level.');
            }
        }
        $manuscript->no_images = true;
        $manuscript->save();
        return redirect()->action([ManuscriptNewController::class, 'show'], $manuscript->id);
    }

    public function allowImages(int $id)
    {
        $manuscript = ManuscriptNew::findOrFail($id);
        $this->checkForProtectedManuscript($id);
        $manuscript->no_images = false;
        $manuscript->save();
        return redirect()->action([ManuscriptNewController::class, 'show'], $manuscript->id);
    }
    public function publishImages(int $id)
    {
        $manuscript = ManuscriptNew::with('images')->findOrFail($id);
        if ($manuscript->no_images) {
            abort(403, "In order to publish images, the manuscript must allow images.");
        }

        foreach ($manuscript->images as $image) {
            if ($image->private_use_only) {

                $image->private_use_only = false;
                Log::info("Making image " . $image->id . " public");
                $image->save();
            }
        }

        return redirect()->action([ManuscriptNewController::class, 'show'], $manuscript->id);

    }

    public function unpublishImages(int $id){
        $manuscript = ManuscriptNew::with('images')->findOrFail($id);
        foreach ($manuscript->images as $image) {
            if (!$image->private_use_only) {

                $image->private_use_only = true;
                Log::info("Making image " . $image->id . " private");
                $image->save();
            }
        }

        return redirect()->action([ManuscriptNewController::class, 'show'], $manuscript->id);

    }


    
    public function publishPages(int $id){
        $manuscript = ManuscriptNew::with('manuscriptPages')->findOrFail($id);
        foreach ($manuscript->manuscriptPages as $page) {
            if (!$page->is_online) {

                $page->is_online = true;
                Log::info("Making page " . $page->id . " public");
                $page->save();
            }
        }

        return redirect()->action([ManuscriptNewController::class, 'show'], $manuscript->id);

    }

    public function unpublishPages(int $id){
        $manuscript = ManuscriptNew::with('manuscriptPages')->findOrFail($id);
        foreach ($manuscript->manuscriptPages as $page) {
            if ($page->is_online) {

                $page->is_online = false;
                Log::info("Making page " . $page->id . " private");
                $page->save();
            }
        }

        return redirect()->action([ManuscriptNewController::class, 'show'], $manuscript->id);

    }


}
