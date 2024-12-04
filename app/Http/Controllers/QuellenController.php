<?php

namespace App\Http\Controllers;

use App\Models\Lesarten\Quelle;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Models\ZoteroBibliography;
use App\Models\Umwelttexte\Belegstelle as InterTexts;

class QuellenController extends Controller
{

    /**
     * Only allow access when logged in
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, ?string $id = null)
    {
        $quelle = $this->createUpdate($request, new Quelle());

        $quelle->save();

        return redirect()->action([QuellenController::class, 'show'], $quelle->id);
    }

}
