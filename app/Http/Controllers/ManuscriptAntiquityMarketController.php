<?php

namespace App\Http\Controllers;

use App\Models\Intertexts\Author;
use App\Models\Manuscripts\ManuscriptAntiquityMarket;
use App\Models\Manuscripts\ManuscriptNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ManuscriptAntiquityMarketController extends Controller
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
        $antiquityMarket = new ManuscriptAntiquityMarket();

        // Fetch attributes fo a author
        $columns = Schema::getColumnListing('ms_antiquity_markets');

        $action = array('App\Http\Controllers\ManuscriptAntiquityMarketController@store');

        // Fill the assitances objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $antiquityMarket[$column] = null;
            }

        }
        $antiquityMarket->manuscript_id = $manuscriptId;

        return view("antiquity_market.create", compact([
            "antiquityMarket",
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
        $antiquityMarket = $this->createUpdate($request);
        $manuscript = $antiquityMarket->manuscript;
        // Save new place
        $antiquityMarket->save();

        return view("antiquity_market.show", compact("antiquityMarket", "manuscript"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $antiquityMarket = ManuscriptAntiquityMarket::find($id);

        $manuscript = $antiquityMarket->manuscript;

        return view("antiquity_market.show", compact(["antiquityMarket", "manuscript"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get antiquity market
        $antiquityMarket = ManuscriptAntiquityMarket::find($id);

        $manuscript = $antiquityMarket->manuscript;

        $action = array('App\Http\Controllers\ManuscriptAntiquityMarketController@update', $id);


        return view("antiquity_market.edit", compact([
            "antiquityMarket",
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
        $antiquityMarket = $this->createUpdate($request, $id);

        // Save new place
        $antiquityMarket->save();

        return view("antiquity_market.show", compact("antiquityMarket"));

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

        $antiquityMarket = new ManuscriptAntiquityMarket();

        if (!empty($id)) {
            $antiquityMarket = ManuscriptAntiquityMarket::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at","manuscript" ]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $antiquityMarket[$parameter] = $content;

            }

        }

        if (!$antiquityMarket->created_by)
            $antiquityMarket->created_by = Auth::user()->name;

        $antiquityMarket->updated_by = Auth::user()->name;

        $antiquityMarket->updated_at = Carbon::now();

        return $antiquityMarket;
    }
}
