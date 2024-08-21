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
            'cadre_id' => 'bigint',
            'nursing_process_id' => 'bigint',
            'taxonomy_level_id' => 'bigint',
            // 'syllabus' => 'string',
            'description_id' => 'required|exists:descriptions,id',
            'title' => 'required|string|max:255',
            'choice_a' => 'required|string|max:255',
            'choice_b' => 'required|string|max:255',
            'choice_c' => 'required|string|max:255',
            'choice_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:A,B,C,D',
            'status' => 'string',
        ];
    }

}