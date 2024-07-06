<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class QuestionController1 extends Controller
{
    public function __construct()
    {
        Inertia::share('activeMenu', 'Questions');
        // $this->authorizeResource(Question::class, '');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Question/Index', [
            'questions' => Question::where('status', 'Unsubmitted')
                ->whenSearch($request->input('search'))
                ->paginate(8)
                ->withQueryString(),
            'filters' => $request->only(['search']) ?? [],
        ]);
    }

    public function fetchQuestions(Request $request)
    {
        // Log the incoming request data for debugging
        Log::info('Request Data:', $request->all());

        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'cadre' => 'required|string',
                'nursing_process' => 'required|string',
                'disease_area' => 'required|string',
                'taxonomy' => 'required|string',
            ]);

            // Log the validated data
            Log::info('Validated Data:', $validatedData);

            // Query the questions table based on the criteria
            $questions = Question::where('cadre', $validatedData['cadre'])
                ->where('nursing_process', $validatedData['nursing_process'])
                ->where('disease_area', $validatedData['disease_area'])
                ->where('taxonomy', $validatedData['taxonomy'])
                ->get();

            // Convert the collection to an array before logging
            Log::info('Retrieved Questions:', $questions->toArray());

            // Return the results as a JSON response
            return response()->json(['questions' => $questions]);
        } catch (\Exception $e) {
            // Log any exception that occurs
            Log::error('Error fetching questions:', ['exception' => $e]);

            // Return a 500 error response
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Question/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQuestionRequest $request
     * @return RedirectResponse
     */
    public function store(StoreQuestionRequest $request): RedirectResponse
    {
        Question::create(array_merge($request->validated(), ['status' => 'Unsubmitted']));
        return redirect()->route('questions.index')->with('success', 'Question successfully created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     
     */
    public function edit(Question $question)
    {
        return Inertia::render('Question/Edit', [
            'question' => $question
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQuestionRequest $request
     * @param Question $question
     * @return RedirectResponse
     */
    public function update(UpdateQuestionRequest $request, Question $question): RedirectResponse
    {
        $question->update($request->validated());
        return redirect()->route('questions.index')->with('success', 'Question successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return RedirectResponse
     */
    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();
        return redirect()->back()->with('success', 'Question successfully deleted');
    }

    /**
     * Submit selected questions.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function submitSelected(Request $request): RedirectResponse
    {
        $uuids = $request->input('uuids', []);
        Question::whereIn('uuid', $uuids)->update(['status' => 'Unvetted']);
        return redirect()->route('questions.index')->with('success', 'Selected questions successfully submitted');
    }
}