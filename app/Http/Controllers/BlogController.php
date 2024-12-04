<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
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
        // Get all Blog entries
        $blogs = Blog::all()->sortByDesc("created_at");

        return view("blog.index", compact("blogs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Create a new blog entry

        $blog = new Blog();

        $action = ['App\Http\Controllers\BlogController@store'];

        return view("blog.create_update", compact(["blog", "action"]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create new blog object
        $blog = new Blog();

        // Save data
        $blog->title = $request->title;
        $blog->entry_content = $request->entry_content;
        $blog->author = Auth::user()->name;

        $blog->save();

        return redirect()->action([BlogController::class, 'show'], [$blog->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get blog entry
        $blog = Blog::find($id);

        return view("blog.show", compact("blog"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get blog entry
        $blog = Blog::find($id);

        $action = array('App\Http\Controllers\BlogController@update', $id);

        return view("blog.create_update", compact(["blog", "action"]));
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
        // Get blog entry
        $blog = Blog::find($id);

        $blog->title = $request->title;
        $blog->entry_content = $request->entry_content;
        $blog->author = Auth::user()->name;

        $blog->save();

        return redirect()->action([BlogController::class, 'show'], [$blog->id]);

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
}
