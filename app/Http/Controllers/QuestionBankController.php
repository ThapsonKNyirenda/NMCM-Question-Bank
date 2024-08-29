<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Question;
use App\Models\Description;
use App\Models\DiseaseArea;

class QuestionBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        Inertia::share('activeMenu', 'Questions Bank');
        //  $this->authorizeResource( Question ::class, '');
    }
    public function index(Request $request)
    {
        $descriptions = Description::where('status', 'vetted')
        ->with(['diseaseArea'])
        ->paginate($request->get('per_page', 10));

    
        return inertia('QuestionBank/Index', [
            'descriptions' => $descriptions,
            'filters' => $request->only(['search', 'per_page']),
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
    public function view($uuid)
    {
        //
        $question = Question::whereUuid($uuid)->firstOrFail();
        return Inertia::render('QuestionBank/View', [
            'question' => $question
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $description = Description::findOrFail($id);
        $diseaseAreas = DiseaseArea::pluck('name', 'id');
        $questions = Question::where('description_id', $id)->get();
        
        
        return Inertia::render('Viewing/Index', [
            'description' => $description,
            'diseaseAreas' => $diseaseAreas,
            'description_id' => $id,
            'questions' => $questions,
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