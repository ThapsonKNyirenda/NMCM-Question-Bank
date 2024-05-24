<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        'title' => 'string',
        'cadre'=> 'string',
        'nursing_process' => 'string',
        'Disease_area' => 'string',
        'syllabus' => 'string',
        'question_description' => 'string',
        'choice_a' => 'string',
        'choice_b' => 'string',
        'choice_c' => 'string',
        'choice_d' => 'string',
        'correct_answer' => 'string',
        'status' => 'nullable'
        ];
    }
}