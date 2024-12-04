<?php

namespace App\Http\Controllers;

use App\Events\UpdateIntertextSourceEvent;
use App\Models\Intertexts\Author;
use App\Models\Intertexts\Intertext;
use App\Models\Intertexts\IntertextEntryTranslation;
use App\Models\Intertexts\IntertextSource;
use App\Models\Intertexts\SourceAuthor;
use App\Models\Manuscripts\ManuscriptColophonTranslation;
use App\Models\Manuscripts\ManuscriptNew;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ManuscriptColophonTranslationController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($manuscriptId)
    {

        $manuscript = ManuscriptNew::find($manuscriptId);
        // Get place
        $colophonTranslation = new ManuscriptColophonTranslation();

        // Fetch attributes fo a author
        $columns = Schema::getColumnListing('ms_manuscript_colophon_text_translations');

        $action = array('App\Http\Controllers\ManuscriptColophonTranslationController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $colophonTranslation[$column] = null;
            }

        }
        $colophonTranslation->manuscript_id = $manuscriptId;

        return view("manuscript_colophon_translations.create", compact([
            "colophonTranslation",
            "manuscript",
            "action"
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Iterate over all parameters of the request and update the original
        $colophonTranslation = $this->createUpdate($request);
        $manuscript = $colophonTranslation->manuscript;
        // Save new place
        $colophonTranslation->save();

        return view("manuscript_colophon_translations.show", compact("colophonTranslation", "manuscript"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $colophonTranslation = ManuscriptColophonTranslation::find($id);

        $manuscript = $colophonTranslation->manuscript;

        return view("manuscript_colophon_translations.show", compact(["colophonTranslation", "manuscript"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get author
        $colophonTranslation = ManuscriptColophonTranslation::find($id);
//        dd($entryTranslation);

        $manuscript = $colophonTranslation->manuscript;

        $action = array('App\Http\Controllers\ManuscriptColophonTranslationController@update', $id);


        return view("manuscript_colophon_translations.edit", compact([
            "colophonTranslation",
            "manuscript",
            "action"
        ]));
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
        // Iterate over all parameters of the request and update the original
        $colophonTranslation = $this->createUpdate($request, $id);

        // Save new place
        $colophonTranslation->save();

        return view("manuscript_colophon_translations.show", compact("colophonTranslation"));

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

    /**
     * Get the manuscript update data return filled manuscript object
     *
     * @param Request $request
     * @param null $id
     * @return Author
     */
    private function createUpdate(Request $request, $id = null)
    {

        $colophonTranslation = new ManuscriptColophonTranslation();

        if (!empty($id)) {
            $colophonTranslation = ManuscriptColophonTranslation::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at","manuscript", "language"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $colophonTranslation[$parameter] = $content;

            }

        }

//        if (!empty($id)) event(new UpdateIntertextSourceEvent($request, $id));

        if (!$colophonTranslation->created_by)
            $colophonTranslation->created_by = Auth::user()->name;

        $colophonTranslation->updated_by = Auth::user()->name;

        $colophonTranslation->updated_at = Carbon::now();

        return $colophonTranslation;
    }
}
