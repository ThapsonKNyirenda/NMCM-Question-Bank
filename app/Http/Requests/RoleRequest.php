<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {

        if ($this->method() === 'POST'){
           return $this->user()->can('create', Role::class);
        }
        return $this->user()->can('update', $this->role);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $uniqueRule = match ($this->method()){
            'POST' => 'unique:roles,name',
            'PATCH',
            'PUT' => Rule::unique('roles','name')->ignore($this->role->id)
        };

        return [
            'name' => ['required','min:2', $uniqueRule],
            'description'=> 'required|min:2|'
        ];
    }
}
