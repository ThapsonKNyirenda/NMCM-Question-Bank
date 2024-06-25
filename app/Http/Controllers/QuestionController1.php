<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * @param Question $question
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
