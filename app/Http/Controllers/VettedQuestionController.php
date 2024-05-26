<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Question;
class VettedQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
          Inertia::share('activeMenu', 'Vetted Questions');
         //  $this->authorizeResource( Question ::class, '');
     }
     public function index(Request $request)
     {
         return Inertia::render('VettedQuestions/Index', [
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
     */
    public function edit(string $id)
    {
        //
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
