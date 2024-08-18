<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Description;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class QuestionController extends Controller
{
    /**
     * Show the form for creating a new question.
     *
     * @param int $description_id
     * @return Response
     */
    public function create(int $description_id): Response
    {
        return Inertia::render('Question/Create', [
            'description_id' => $description_id,
        ]);
    }

    /**
     * Store a newly created question in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'description_id' => 'required|exists:descriptions,id',
            'title' => 'required|string|max:255',
            'choice_a' => 'required|string|max:255',
            'choice_b' => 'required|string|max:255',
            'choice_c' => 'required|string|max:255',
            'choice_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        // Create the question
        Question::create($validatedData);

        // Redirect back to the description create page with the description_id
        return redirect()->route('descriptions.create', ['description_id' => $validatedData['description_id']])
                         ->with('success', 'Question added successfully');
    }
}