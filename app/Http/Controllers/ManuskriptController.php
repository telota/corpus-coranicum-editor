<?php

namespace App\Http\Controllers;

use App\Events\UpdateManuskriptEvent;
use App\Models\Manuskripte\Aufbewahrungsort;
use App\Events\PublishManuscriptEvent;
use App\Models\Helpers\ZoteroHelper;
use App\Models\Manuskripte\Manuskript;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;

class ManuskriptController extends Controller
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
        return view("manuskripte.index", ["manuskripte" => Manuskript::all()])->render();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get Manuscript
        $manuskript = Manuskript::find($id);

        JavaScript::put([
            // $manuskript isn't being reused here, because it adds the manuskriptseiten-Relation
            // to the records attributes. This intereferes with the metadata blade
            'onlineStatus' => Manuskript::find($id)->isOnline,
            "manuskriptId" => $id
        ]);

        return view("manuskripte.show", compact("manuskript"));
    }

}
