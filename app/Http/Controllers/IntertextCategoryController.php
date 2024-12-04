<?php

namespace App\Http\Controllers;

use App\Events\UpdateIntertextCategoryEvent;
use App\Models\Intertexts\IntertextCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IntertextCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = IntertextCategory::all();


        return view("intertext_categories.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $intertextCategory = new IntertextCategory();
//        $categories = IntertextCategory::all();

//        $superCategories = [[1, "keine"]];
//        foreach($categories as $category){
//            if($category->supercategory == 1){
//                array_push($superCategories, [$category->id, $category->category_name]);
//            }
//        }
        // Fetch attributes fo a category
        $columns = Schema::getColumnListing('it_categories');
        $action = array('App\Http\Controllers\IntertextCategoryController@store');

        // Fill the category objects with empty values so the
        // attributes can be accessed in the create view.
        foreach ($columns as $column) {
            if (!($column == "id") | !($column == "created_at") | !($column == "updated_at")) {
                $intertextCategory[$column] = null;
            }

        }

        return view("intertext_categories.create", compact(["intertextCategory", "action"]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = IntertextCategory::create($request->all());

        $category->save();
        return view("intertext_categories.show", compact(["category"]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get original codex
        $category = IntertextCategory::find($id);

        return view("intertext_categories.show", compact(["category"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $intertextCategory = IntertextCategory::find($id);
//        $intertextCategories = IntertextCategory::all();


//        $superCategories = [[1, "keine"]];
//        foreach($intertextCategories as $category){
//                if($category->supercategory == 1){
//                    array_push($superCategories, [$category->id, $category->category_name]);
//                }
//            }

        $action = array('App\Http\Controllers\IntertextCategoryController@update', $id);
        return view("intertext_categories.edit", compact(["intertextCategory","action"]));
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
//        $category = IntertextCategory::find($id);
//        $category->category_name = $request->category_name;
//        $category->classification = $request->classification;
//        $category->supercategory = $request->supercategory;
//        $category->save();

        // Iterate over all parameters of the request and update the original
        $category = $this->createUpdate($request, $id);

        // Save new place
        $category->save();


        return view("intertext_categories.show", compact(["category"]));
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

        $category = new IntertextCategory();

        if (!empty($id)) {
            $category = IntertextCategory::find($id);
        }

        foreach ($request->except(["_token", "files", "updated_at", "created_at", "info_authors"]) as $parameter => $content) {

            if (!in_array(strtolower($parameter), array("id"))) {

                $category[$parameter] = $content;

            }

        }

        if (!empty($id)) event(new UpdateIntertextCategoryEvent($request, $id));

        if (!$category->created_by)
            $category->created_by = Auth::user()->name;

        $category->updated_by = Auth::user()->name;

        $category->updated_at = Carbon::now();


        return $category;
    }
}
