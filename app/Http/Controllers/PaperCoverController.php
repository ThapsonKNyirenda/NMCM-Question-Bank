<?php

namespace App\Http\Controllers;

use App\Models\PaperCover;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PaperCoverController extends Controller
{
    public function __construct()
    {
         Inertia::share('activeMenu', 'Paper Covers');
        //  $this->authorizeResource( PaperCover ::class, '');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('PaperCover/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('PaperCover/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        PaperCover::create($request->validated());
        return redirect()->route('.index')->with('success', ' successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaperCover $paperCover)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaperCover  $paperCover
     * @return Response
     */
    public function edit(PaperCover $paperCover)
    {
        return Inertia::render('PaperCover/Edit', [
            'paperCover' => $paperCover
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaperCover  $paperCover
     * @return RedirectResponse
     */
    public function update(Request $request, PaperCover $paperCover)
    {
       $paperCover->update($request->validated());
       return redirect()->route('.index')->with('success', ' successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaperCover $paperCover)
    {
        //
    }
}