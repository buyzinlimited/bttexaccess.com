<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use App\Models\Page;

class PageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {

        return inertia('Dashboard/Pages/Index', [
            'pages' => Page::orderBy('created_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create()
    {
        return inertia('Dashboard/Pages/Create',[
            'main_url' => URL::route('pages.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $page = new Page();

        $page->title = Request::input('title');
        $page->slug = Request::input('slug');
        $page->summery = Request::input('summery');
        $page->is_delete= true;
        $page->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(Page $page)
    {
        return inertia('Dashboard/Pages/Edit',[
            'update_url' => URL::route('pages.updatePage', $page->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */


    public function updatePage($id)
    {
        $page = Page::findOrFail($id);
        $page->title = Request::input('title');
        $page->slug = Request::input('slug');
        $page->summery = Request::input('summery');
        $page->update();

        return redirect()->route('pages.index')->with('message', 'Your page Updated...');
    }


    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return back();
    }
}
