<?php

namespace App\Http\Controllers;

use App\Models\QuestionBlueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QuestionBlueprintController extends Controller
{
    public function __construct()
    {
         Inertia::share('activeMenu', 'Question Papers');
        //  $this->authorizeResource( QuestionBlueprint ::class, '');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('QuestionPaper/Index',[
            'questionBlueprints' => QuestionBlueprint::whenSearch($request->input('search'), [])
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
        return Inertia::render('QuestionPaper/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        QuestionBlueprint::create($request->validated());
        return redirect()->route('.index')->with('success', ' successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionBlueprint $questionBlueprint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionBlueprint  $questionBlueprint
     * @return Response
     */
    public function edit(QuestionBlueprint $questionBlueprint)
    {
        return Inertia::render('QuestionBlueprint/Edit', [
            'questionBlueprint' => $questionBlueprint
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionBlueprint  $questionBlueprint
     * @return RedirectResponse
     */
    public function update(Request $request, QuestionBlueprint $questionBlueprint)
    {
       $questionBlueprint->update($request->validated());
       return redirect()->route('.index')->with('success', ' successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionBlueprint $questionBlueprint)
    {
        //
    }
}