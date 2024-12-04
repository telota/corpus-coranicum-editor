<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\ZoteroBibliography;

class ZoteroController extends Controller
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
        $bibliography = ZoteroBibliography::all();
        return view("zotero.bibliography", ['bibliography' => $bibliography]);
    }
}
