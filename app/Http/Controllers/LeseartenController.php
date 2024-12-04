<?php

namespace App\Http\Controllers;

use App\Models\Koran;
use App\Models\Koranstelle;
use App\Models\Lesarten\Leseart;
use App\Models\Lesarten\LeseartLeser;
use App\Models\Lesarten\QuelleLeseartMapping;
use App\Models\Sure;
use App\Models\Lesarten\Variante;
use App\Rules\QuranVerseExists;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class LeseartenController extends Controller
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
    public function index($page = 1)
    {
        // Get all lesearten
        $lesearten = Leseart::paginate($page * 500);

        return view("leseart.index", compact("lesearten", "page"));
    }

    public function createFromSource(Request $request, $quelle)
    {
        return self::createView($request, $leser = 0, $quelle);
    }

    public function create(Request $request, $leser = 0, $quelle = 0)
    {
        return self::createView($request, $leser, $quelle);

    }

    private static function createView(Request $request, $leser = 0, $quelle = 0)
    {
        // Create new Leseart
        $leseart = new Leseart();

        $columns = Schema::getColumnListing('lc_leseart');

        foreach ($columns as $column => $content) {
            $leseart[$column] = $content;
        }

        // Set initial sure and vers to 1 to prepare the variant listing
        $leseart->sure = 1;
        $leseart->vers = 1;

        $words = Koranstelle::getVers($leseart->sure, $leseart->vers);

        $action = route('lesearten.store');

        return view("leseart.create_update", compact("leseart", "action", "quelle", "leser", "words"));
    }

    /**
     * Show the form for creating a new resource with a given Koranstelle
     *
     * @param int $sure
     * @param int $vers
     * @param int $quelle
     * @param int $leser
     */
    public function createKoranstelle($sure = 1, $vers = 1, $quelle = 0, $leser = 0): View
    {
        // Create new Leseart
        $leseart = new Leseart();

        $columns = Schema::getColumnListing('lc_leseart');

        foreach ($columns as $column => $content) {
            $leseart[$column] = $content;
        }

        // Set initial sure and vers to 1 to prepare the variant listing
        $leseart->sure = $sure;
        $leseart->vers = $vers;

        $words = Koranstelle::getVers($leseart->sure, $leseart->vers);


        $action = route('lesearten.store');

        return view("leseart.create_update", compact("leseart", "action", "quelle", "leser", "words"));
    }

    public function store(Request $request, $id = null)
    {
        // Validate input
        $this->validate($request, [
            'sure' => 'required',
            'vers' => [new QuranVerseExists()],
            'variante' => 'leseart_varianten',
            'Leser' => 'required',
        ]);

        if ($id == null) {
            $leseart = new Leseart();
        } else {
            $leseart = Leseart::find($id);
        }


        // Update parameters
        $leseart->sure = $request->sure;
        $leseart->vers = $request->vers;
        $leseart->kommentar = $request->kommentar;
        $leseart->kommentar_intern = $request->kommentar_intern;
        $leseart->quelle_id = $request->Quelle;
        $leseart->save();

        $leseart->leser()->sync(collect($request->Leser)->filter());

        // Iterate over all variants
        foreach ($request->variante as $word => $variant) {
            if (empty($variant)) {
                continue;
            }
            if ($leseart->varianten->contains('wort', $word)) {
                $existing = $leseart->varianten->first(fn($v) => $v->wort == $word);
                if ($existing->variante !== $variant) {
                    $existing->variante = $variant;
                    $existing->save();
                }
            } else {

                $new = new Variante();
                $new->leseart = $leseart->id;
                $new->wort = $word;
                $new->variante = $variant;
                $new->save();

            }
        }

        foreach ($leseart->varianten as $variante) {
            if (!collect($request->variante)->filter()->has($variante->wort)) {
                $variante->delete();
            }

        }

        // If next is true, jump to the readings with the same Quelle and Leser,
        // but for the next verse
        if ($request->next) {
            // Create Koranstelle and get the next one
            $currentKoranstelle = new Koranstelle();
            $currentKoranstelle->sure = $request->sura_selected[0];
            $currentKoranstelle->vers = $request->verse_selected[0];

            $nextKoranstelle = $currentKoranstelle->getNextVerse();

            return redirect()->route("lesearten.createLeseartKoranstelleQuelleLeser", array(
                $nextKoranstelle->sure,
                $nextKoranstelle->vers,
                $request->Quelle,
                $request->Leser
            ));

        }

        return redirect()->action([LeseartenController::class, 'show'], $leseart->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($id): View
    {
        // Get reading
        $leseart = Leseart::find($id);
        return view("leseart.show", compact("leseart"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        // Get leseart
        $leseart = Leseart::find($id);

        $words = Koranstelle::getVers($leseart->sure, $leseart->vers);

        $action = route('lesearten.update', ['id' => $id]);

        return view("leseart.create_update", compact("leseart", "action", "words"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        $leseart = Leseart::find($id);
        $leseart->delete();

        Session::flash("flash_type", "alert-success");
        Session::flash("flash_message", "Leseart erfolgreich gelöscht.");

        return redirect()->action([LeseartenController::class, 'index'], 1);
    }

    /**
     * Generate index view for lesearten based on sura
     *
     * @param int $sure
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public
    function koranstellenIndex($sure = 1)
    {
        $maxVers = Sure::getMaxVers($sure);

        return view("leseart.koranstellen", compact("sure", "maxVers"));
    }

    /**
     * Generate show view for lesearten based on sura
     *
     * @param $sure
     * @param $vers
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public
    static function koranstellenShow($sure, $vers)
    {
        $lesearten = Leseart::where("sure", $sure)
            ->where("vers", $vers)
            ->get();

        return view("leseart.koranstellenshow", compact("lesearten", "sure", "vers"));
    }

    /**
     * Show the commentary of a reading
     *
     * @param $sure
     * @param $vers
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public
    static function kommentarShow($sure, $vers)
    {
        $kommentar = Koran::getLeseartenKommentar($sure, $vers);

        if (empty($kommentar)) {
            $kommentar = "Kein Kommentar vorhanden";
        }

        return view("leseart.kommentarshow", compact("kommentar", "sure", "vers"));
    }

    /**
     * Edit the commentary of a reading
     *
     * @param $sure
     * @param $vers
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public
    static function kommentarEdit($sure, $vers)
    {
        $kommentar = Koran::getLeseartenKommentar($sure, $vers);
        return view("leseart.kommentaredit", compact("kommentar", "sure", "vers"));
    }


    /**
     * Update the reading commentary.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public
    static function kommentarUpdate(Request $request)
    {
        $koranstelle = Koran::where("sure", $request->sure)
            ->where("vers", $request->vers)
            ->first();

        $koranstelle->kommentar = $request->kommentar;

        $koranstelle->save();

        return redirect()->action([LeseartenController::class, 'kommentarShow'], [$request->sure, $request->vers]);
    }

    /**
     * Generate a list of readings where a specific word occurs
     */
    public
    static function wordIndex($word)
    {
        // Get variants with the specified word
        $variants = Variante::getVariantsByWord($word);

        return view("leseart.wordindex", compact("word", "variants"));
    }
}
