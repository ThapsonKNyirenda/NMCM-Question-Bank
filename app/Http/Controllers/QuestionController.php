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
         $pageType = $request->query('pageType', 'defaultType');
         
         return inertia('Question/Create', [
             'cadres' => $cadres,
             'nursingProcesses' => $nursingProcesses,
             'taxonomyLevels' => $taxonomyLevels,
             'description_id' => $description_id,
             'pageType' => $pageType,
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

        $pageType = $request->input('pageType');

        if ($pageType == 'descAdd') {
            return redirect()->route('descriptions.create', ['description_id' => $question['description_id']])
            ->with('success', 'Question added successfully');
        } else if ($pageType == 'descEdi'){
            return redirect()->route('descriptions.edit', ['description' => $question['description_id']])
                 ->with('success', 'Question added successfully');
        }else if ($pageType == 'unvetEdi'){
            return redirect()->route('unvettedquestions.edit', ['unvettedquestion' => $question['description_id']])
                 ->with('success', 'Question Item Updated successfully');
        }
       
    }

    public function edit($id, Request $request)
{
    // Retrieve the question by ID
    $question = Question::findOrFail($id);

    // Retrieve relationships
    $taxonomyLevels = TaxonomyLevel::pluck('name', 'id');
    $cadres = Cadre::pluck('name', 'id');
    $nursingProcesses = NursingProcess::pluck('name', 'id');

    //pageType value
    $pageType = $request->query('pageType', 'defaultType');

    // Pass the question data and relationships to the edit form
    return inertia('Question/Edit', [
        'question' => $question,
        'cadres' => $cadres,
        'nursingProcesses' => $nursingProcesses,
        'taxonomyLevels' => $taxonomyLevels,
        'description_id' => $question->description_id,
        'pageType' => $pageType,   
    ]);
}

public function update(Request $request, $id): RedirectResponse
{
    // Validate the request data
    $validatedData = $request->validate([
        'cadre' => 'required|exists:cadres,id',
        'nursing_process' => 'required|exists:nursing_processes,id',
        'taxonomy' => 'required|exists:taxonomy_levels,id',
        'syllabus' => 'required|string|max:4',
        'title' => 'required|string|max:255',
        'choice_a' => 'required|string|max:255',
        'choice_b' => 'required|string|max:255',
        'choice_c' => 'required|string|max:255',
        'choice_d' => 'required|string|max:255',
        'correct_answer' => 'required|string|in:A,B,C,D',
    ]);

    // Find the question by ID
    $question = Question::findOrFail($id);

    // Update the question with the validated data
    $question->update([
        'cadre_id' => $validatedData['cadre'],
        'nursing_process_id' => $validatedData['nursing_process'],
        'taxonomy_level_id' => $validatedData['taxonomy'],
        'syllabus' => $validatedData['syllabus'],
        'title' => $validatedData['title'],
        'choice_a' => $validatedData['choice_a'],
        'choice_b' => $validatedData['choice_b'],
        'choice_c' => $validatedData['choice_c'],
        'choice_d' => $validatedData['choice_d'],
        'correct_answer' => $validatedData['correct_answer'],
    ]);

    $pageType = $request->input('pageType');
    

        if ($pageType == 'descAdd') {
            return redirect()->route('descriptions.create', ['description_id' => $question->description_id])
                     ->with('success', 'Question updated successfully');
        } else if ($pageType == 'descEdi'){
            return redirect()->route('descriptions.edit', ['description' => $question->description_id])
                     ->with('success', 'Question updated successfully');
        } else if  ($pageType == 'unvetEdi') {
            return redirect()->route('unvettedquestions.edit', ['unvettedquestion' => $question->description_id])
                     ->with('success', 'Question updated successfully');
        }

    // Redirect back to the description creation page with a success message
    
}

public function destroy($id): RedirectResponse
{
    // Find the question by ID
    $question = Question::findOrFail($id);

    // Store the description_id before deleting the question
    $description_id = $question->description_id;

    // Delete the question
    $question->delete();

    return redirect()->back()
                     ->with('success', 'Question deleted successfully');
}

// public function sceCreate(Request $request)
//      {
//          // Retrieving relationships
//          $taxonomyLevels = TaxonomyLevel::pluck('name', 'id');
//          $cadres = Cadre::pluck('name', 'id');
//          $nursingProcesses = NursingProcess::pluck('name', 'id');
     
//          // Retrieve the description_id from the query parameters
//          $description_id = $request->query('description_id');
         
//          return inertia('Question/SceCreate', [
//              'cadres' => $cadres,
//              'nursingProcesses' => $nursingProcesses,
//              'taxonomyLevels' => $taxonomyLevels,
//              'description_id' => $description_id,
//          ]);
//      }

//      public function sceStore(StoreQuestionRequest $request): RedirectResponse
//     {

//         // Create the question
//         //$question = Question::create(array_merge($validatedData, ['status' => 'unset']));

//         $question = Question::create([
//             'cadre_id' => $request->input('cadre'),
//             'nursing_process_id' => $request->input('nursing_process'),
//             'taxonomy_level_id' => $request->input('taxonomy'),
//             'description_id' => $request->input('description_id'),
//             'title' => $request->input('title'),
//             'choice_a' => $request->input('choice_a'),
//             'choice_b' => $request->input('choice_b'),
//             'choice_c' => $request->input('choice_c'),
//             'choice_d' => $request->input('choice_d'),
//             'correct_answer' => $request->input('correct_answer'),
//             'syllabus' => $request->input('syllabus'),
//             'status' => 'unset'

//         ]);
        
//         // Redirect back to the description create page with the description_id
//         return redirect()->route('descriptions.edit', ['description' => $question['description_id']])
//                  ->with('success', 'Question added successfully');

//     }

}