<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreQuestionBlueprintRequest;
use App\Models\Question;
use App\Models\QuestionBlueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\UpdateQuestionBlueprintRequest;

class QuestionBlueprintManagerController extends Controller
{
    public function __construct()
    {
         Inertia::share('activeMenu', 'Question Papers');
        //  $this->authorizeResource( QuestionBlueprint ::class, '');
    }

    public function descriptionsByCadre(Request $request)
    {
        $cadre = $request->query('cadre');
        $questions = Question::where('cadre', $cadre)
            ->get(['question_description', 'choice_a', 'choice_b', 'choice_c', 'choice_d']);
        return response()->json(['questions' => $questions]);
    }

    public function showQuestionPaper(Request $request)
    {
        $questions = $request->input('questions');
        return Inertia::render('QuestionPaper', ['questions' => $questions]);
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
    public function store(StoreQuestionBlueprintRequest $request)
    {
        QuestionBlueprint::create($request->validated());
        return redirect()->route('questionblueprints.index')->with('success', ' successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionBlueprint $questionBlueprint)
    {
        //
    }

    public function edit($uuid): Response
    {
        $questionBlueprint = QuestionBlueprint::where('uuid', $uuid)->first();
        return Inertia::render('QuestionPaper/Edit', [
            'blueprint' => $questionBlueprint
        ])->with('blueprint', $questionBlueprint);
    }

// public function update(UpdateQuestionBlueprintRequest $request, QuestionBlueprint $questionBlueprint): RedirectResponse
// {
//     $validated = $request->validate([
//         'cadre' => 'required|string',
//         'nursing_process' => 'required|string',
//         'disease_area' => 'required|string',
//         'taxonomy' => 'required|string',
//         'syllabus' => 'required|string',
//         'number_of_questions' => 'required|integer',
//         'question_paper_code' => 'required|string',
//     ]);

//     $questionBlueprint->update($validated);

//     return redirect()->route('questionblueprints.index')->with('success', 'Blueprint successfully updated');
// }


public function update(UpdateQuestionBlueprintRequest $request, $uuid): RedirectResponse
{
    $questionBlueprint = QuestionBlueprint::where('uuid', $uuid)->first();
    $questionBlueprint->update($request->validated());
    return redirect()->route('questionblueprints.index')->with('success', 'Blueprint successfully updated');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionBlueprint $questionBlueprint, $uuid)
{
    $questionBlueprint = QuestionBlueprint::where('uuid', $uuid)->first();
    $questionBlueprint->delete();
    return redirect()->route('questionblueprints.index')->with('success', 'Blueprint successfully deleted');
}
}