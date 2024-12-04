<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manuscripts\ManuscriptPageMapping;

class MappingController extends Controller
{
    public function newMapping($withWord = true)
    {
        // Create a new mapping object
        // Return the view

        $mapping = new ManuscriptPageMapping();
        $mapping->sura_start = -1;
        $mapping->sura_end = -1;
        return view('components.form.quran-mapping', ["m" => $mapping,
            "withWord" => $withWord]);
    }
}
