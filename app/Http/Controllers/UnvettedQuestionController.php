<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\UnvettedQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UnvettedQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
    {
         Inertia::share('activeMenu', 'Unvetted Questions');
        //  $this->authorizeResource( Question ::class, '');
    }
    
    public function index(Request $request)
    {
        return Inertia::render('UnvettedQuestion/Index', [
            'questions' => Question::whenSearch($request->input('search'))
                ->paginate(10)
                ->withQueryString(),
            'filters' => $request->only(['search']) ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \App\Models\Question  $question
     * @return Response
     */
    public function edit(Question $question)
    {
        return Inertia::render('Question/Edit', [
            'question' => $question
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}