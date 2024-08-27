<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Description;
use App\Models\TaxonomyLevel;
use App\Models\NursingProcess;
use App\Models\Cadre;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\StoreQuestionRequest;

class QuestionController extends Controller
{
    /**
     * Show the form for creating a new question.
     *
     * @param int $description_id
     * @return Response
     */

     public function create(Request $request)
     {
         // Retrieving relationships
         $taxonomyLevels = TaxonomyLevel::pluck('name', 'id');
         $cadres = Cadre::pluck('name', 'id');
         $nursingProcesses = NursingProcess::pluck('name', 'id');
     
         // Retrieve the description_id from the query parameters
         $description_id = $request->query('description_id');
         
         return inertia('Question/Create', [
             'cadres' => $cadres,
             'nursingProcesses' => $nursingProcesses,
             'taxonomyLevels' => $taxonomyLevels,
             'description_id' => $description_id,
         ]);
     }
     
    

    /**
     * Store a newly created question in storage.
     *
     * @param StoreQuestionRequest $request
     * @return RedirectResponse
     */
    public function store(StoreQuestionRequest $request): RedirectResponse
    {

        // Create the question
        //$question = Question::create(array_merge($validatedData, ['status' => 'unset']));

        $question = Question::create([
            'cadre_id' => $request->input('cadre'),
            'nursing_process_id' => $request->input('nursing_process'),
            'taxonomy_level_id' => $request->input('taxonomy'),
            'description_id' => $request->input('description_id'),
            'title' => $request->input('title'),
            'choice_a' => $request->input('choice_a'),
            'choice_b' => $request->input('choice_b'),
            'choice_c' => $request->input('choice_c'),
            'choice_d' => $request->input('choice_d'),
            'correct_answer' => $request->input('correct_answer'),
            'syllabus' => $request->input('syllabus'),
            'status' => 'unset'

        ]);
        
        // Redirect back to the description create page with the description_id
        return redirect()->route('descriptions.create', ['description_id' => $question['description_id']])
                         ->with('success', 'Question added successfully');
    }

    public function edit($id, Request $request)
{
    // Retrieve the question by ID
    $question = Question::findOrFail($id);

    // Retrieve relationships
    $taxonomyLevels = TaxonomyLevel::pluck('name', 'id');
    $cadres = Cadre::pluck('name', 'id');
    $nursingProcesses = NursingProcess::pluck('name', 'id');

    // Pass the question data and relationships to the edit form
    return inertia('Question/Edit', [
        'question' => $question,
        'cadres' => $cadres,
        'nursingProcesses' => $nursingProcesses,
        'taxonomyLevels' => $taxonomyLevels,
        'description_id' => $question->description_id,
    ]);
}

}