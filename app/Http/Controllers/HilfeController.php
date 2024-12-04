<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HilfeController extends Controller
{
    /**
     * Only allow access when logged in
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a manual of oxygen-xml.
     *
     * @param null $sure
     * @param null $sprache
     * @return \Illuminate\Http\Response
     */
    public function oxygenXml()
    {
        return view("help.oxygen_xml");
    }
}
