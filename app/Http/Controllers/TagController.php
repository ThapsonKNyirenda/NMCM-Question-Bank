<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends Controller
{
    public function __construct()
    {
         Inertia::share('activeMenu', '');
         $this->authorizeResource( Tag ::class, '');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Tag/Index',[
            'tags' => Tag::whenSearch($request->input('search'), [])
                ->paginate(8)
                ->withQueryString(),
            'filters' => $request->only(['search']) ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Tag/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        Tag::create($request->validated());
        return redirect()->route('.index')->with('success', ' successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return Response
     */
    public function edit(Tag $tag)
    {
        return Inertia::render('Tag/Edit', [
            'tag' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return RedirectResponse
     */
    public function update(Request $request, Tag $tag)
    {
       $tag->update($request->validated());
       return redirect()->route('.index')->with('success', ' successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
