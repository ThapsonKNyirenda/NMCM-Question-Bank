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
         return Inertia::render('VettedQuestion/Index', [
             'questions' => Question:: where('status', 'Vetted')
             ->whenSearch($request->input('search'))
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
   

    /**
     * Show the form for editing the specified resource.
     */
    public function show($uuid)
    {
        //
        $question = Question::whereUuid($uuid)->firstOrFail();
        return Inertia::render('VettedQuestion/View', [
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

    public function unvet($uuid)
{
    // Retrieve the question using the UUID
    $question = Question::whereUuid($uuid)->firstOrFail();

    // Update the status to "Vetted"
    $question->status = 'Unvetted';

    // Save the changes to the database
    $question->save();

    // Redirect to the index page using Inertia
    return redirect()->route('vettedquestions.index')->with('success', 'Question successfully Unvetted');
}
}