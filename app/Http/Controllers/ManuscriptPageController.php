<?php

namespace App\Http\Controllers;

use App\Enums\FormAction;
use App\Events\UpdateManuscriptMappingsEvent;
use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuscripts\ManuscriptPage;
use App\Models\Manuscripts\ManuscriptPageImage;
use App\Models\Manuscripts\ManuscriptPageMapping;
use App\Models\Transliteration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class ManuscriptPageController extends Controller
{

    /**
     * Only allow access when logged in
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($manuscript_id)
    {
        $page = new ManuscriptPage();
        $manuscript = ManuscriptNew::findOrFail($manuscript_id);
        $page->manuscript = $manuscript;
        $page->manuscript_id = $manuscript->id;
        $page->mappings = [new ManuscriptPageMapping()];

        $submitUrl = route('ms_page_create', ['manuscript_id' => $manuscript_id]);

        return view(
            "manuscript_page",
            [
                "page" => $page,
                "action" => FormAction::Create,
                "form_action" => $submitUrl,
            ]
        );
    }
    // public function createHandler(Request $request, $manuscript_id)

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function createOrEditHandler(Request $request, $manuscript_id, $page_id = null)
    {
        $this->validate($request, [
            "folio" => 'required',
            //TODO: update this
            // "sura_start" => 'required|textstellen_gt'
        ]);

        $manuscriptPage = $this->saveToDatabase($request, $page_id);
        $page_id = $manuscriptPage->id;

        Session::flash(
            "flash_message",
            "Manuskriptseite '{$request->folio} {$request->page_side}' von {$manuscriptPage->manuscript->getName()} 
                wurde aktualisiert"
        );
        Session::flash("flash_type", "alert-info");

        return redirect()
            ->action([ManuscriptPageController::class, 'show'], compact("manuscript_id", "page_id"));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($manuscript_id, $page_id)
    {

        return view(
            "manuscript_page",
            [
                "page" => ManuscriptPage::with(['manuscript', 'images', 'mappings'])->find($page_id),
                "action" => FormAction::Show,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($manuscript_id, $page_id)
    {
        $page = ManuscriptPage::with(['manuscript', 'images', 'mappings'])->find($page_id);
        $submitUrl = action(
            [ManuscriptPageController::class, 'createOrEditHandler'],
            compact("manuscript_id", "page_id")
        );

        return view(
            "manuscript_page",
            [
                "page" => $page,
                "action" => FormAction::Edit,
                "form_action" => $submitUrl,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $r, $manuscript_id, $page_id)
    {
        // Get Manuskriptseite
        $page = ManuscriptPage::findOrFail($page_id);


        foreach ($page->images as $image) {
            if (isset($image->image_link)) {
                ManuscriptPageImageController::deleteFile($image->image_link);
            }
        }

        $page->delete();
        UpdateManuscriptMappingsEvent::dispatch($manuscript_id);

        return redirect()->action([ManuscriptNewController::class, 'show'], $manuscript_id);
    }

    /**
     * Get the manuscript update data return filled manuscript object
     *
     * @param Request $request
     * @param null $id
     * @return ManuscriptPage
     */
    private function saveToDatabase(Request $request, $id = null)
    {
        $manuscriptPage = new ManuscriptPage();

        if (!empty($id)) {
            $manuscriptPage = ManuscriptPage::findOrFail($id);
        }

        foreach (['folio', 'page_side', 'is_online'] as $field) {
            $manuscriptPage->$field = $request[$field];
        }


        if (empty($id)) {
            // Make temporary save to instantiate new manuscript pages
            $manuscriptPage->manuscript_id = $request->manuscript_id;
            $manuscriptPage->save();
        }

        $manuscriptPage->save();

        // Get the manuscript
        $manuscript = ManuscriptNew::find($manuscriptPage->manuscript_id);

        // Update manuscript page mappings
        $this->updateMappings(
            $request,
            sizeof($manuscriptPage->mappings) > 0 ? $manuscriptPage->mappings : array(),
            $manuscriptPage->id
        );

        // Save manuscript
        $manuscript->save();

        UpdateManuscriptMappingsEvent::dispatch($manuscript->id);

        // Return manuscript page. It will be saved in the parent function.
        return $manuscriptPage;
    }


    /**
     * Read Sura and Vers values and update the ManuskriptseitenMappings
     * of a manuscript page.
     *
     * @param Request $request
     * @param $mappings - ManuskriptseitenMapping
     * @param $manuscriptPageId
     */
    private function updateMappings(Request $request, $mappings, $manuscriptPageId)
    {

        if (!isset($request["sura_start"])) {
            ManuscriptPageMapping::where('manuscript_page_id', $manuscriptPageId)->delete();
            return;
        }

        // Iterate over all existing mappings and create new ones if needed
        for ($i = 0; $i < sizeof($request["sura_start"]); $i++) {
            // If counter i is smaller than the size of $mappings, update the mapping
            $word_start = null;
            $word_end = null;
            if ($request["word_start"]) {
                $word_start = $request["word_start"][$i] == -1 ? null : $request["word_start"][$i];
            }
            if ($request["word_end"]) {
                $word_end = $request["word_end"][$i] == -1 ? null : $request["word_end"][$i];
            }

            if ($i < sizeof($mappings)) {
                $mappings[$i]["sura_start"] = $request["sura_start"][$i];
                $mappings[$i]["verse_start"] = $request["verse_start"][$i];
                $mappings[$i]["word_start"] = $word_start;

                $mappings[$i]["sura_end"] = $request["sura_end"][$i];
                $mappings[$i]["verse_end"] = $request["verse_end"][$i];
                $mappings[$i]["word_end"] = $word_end;

                $mappings[$i]->save();
            } else {
                // Else, create new mapping
                $newMapping = new ManuscriptPageMapping();
                $newMapping["manuscript_page_id"] = $manuscriptPageId;

                $newMapping["sura_start"] = $request["sura_start"][$i];
                $newMapping["verse_start"] = $request["verse_start"][$i];
                $newMapping["word_start"] = $request["word_start"][$i];

                $newMapping["sura_end"] = $request["sura_end"][$i];
                $newMapping["verse_end"] = $request["verse_end"][$i];
                $newMapping["word_end"] = $request["word_end"][$i];

                $newMapping->save();
            }
        }
        // Delete unneeded Textstellen
        if (sizeof($request["sura_start"]) < sizeof($mappings)) {
            for ($i = sizeof($mappings); $i > sizeof($request["sura_start"]); $i--) {
                $mappings[$i - 1]->delete();
            }
        }
    }

}
