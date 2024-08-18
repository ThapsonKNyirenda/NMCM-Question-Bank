<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DescriptionStoreRequest extends FormRequest
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
            'disease_area_id' => 'bigint',
            'taxonomy_level_id' => 'bigint',
            'syllabus' => 'string',
            'description' =>'text'
        ];
    }

}