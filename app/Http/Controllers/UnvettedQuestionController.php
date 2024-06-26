<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;
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
            'questions' => Question::where('status', 'Unvetted')
                ->whenSearch($request->input('search'))
                ->paginate(10)
                ->withQueryString(),
            'filters' => $request->only(['search']) ?? [],
        ]);
    }

    public function bulkVet(Request $request)
    {
        $uuids = $request->input('uuids');

        if (empty($uuids)) {
            return response()->json(['message' => 'No questions selected'], 400);
        }

        Question::whereIn('uuid', $uuids)->update(['status' => 'Vetted']);

        return redirect()->route('unvettedquestions.index')->with('success', ' successfully Vetted Selected questions');
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
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     * @param  \App\Models\Question  $question
     * @return Response
     */
    public function edit($uuid)
    {
        $question = Question::whereUuid($uuid)->firstOrFail();
        return Inertia::render('UnvettedQuestion/Edit', [
            'question' => $question
        ]);
    }

    public function update(UpdateQuestionRequest $request, $uuid): RedirectResponse
    {
        $question = Question::whereUuid($uuid)->firstOrFail();
        $question->update($request->validated());
    
        return redirect()->route('unvettedquestions.index')->with('success', 'Question successfully updated');
    }
    
    /**
 * Update the status of the specified resource to "Vetted".
 * @param  string  $uuid
 * @return \Inertia\Response
 */
public function show($uuid)
{
    // Retrieve the question using the UUID
    $question = Question::whereUuid($uuid)->firstOrFail();

    // Update the status to "Vetted"
    $question->status = 'Vetted';

    // Save the changes to the database
    $question->save();

    // Redirect to the index page using Inertia
    return Inertia::render('UnvettedQuestion/Index', [
        'questions' => Question::all()  // Adjust this to fit your index page data requirements
    ]);
}


/**
 * Update the status of the specified resource to "Vetted".
 * @param  string  $uuid
 * @return \Inertia\Response
 */
public function vet($uuid)
{
    // Retrieve the question using the UUID
    $question = Question::whereUuid($uuid)->firstOrFail();

    // Update the status to "Vetted"
    $question->status = 'Vetted';

    // Save the changes to the database
    $question->save();

    // Redirect to the index page using Inertia
    return redirect()->route('unvettedquestions.index')->with('success', 'Question successfully Vetted');
}


    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}