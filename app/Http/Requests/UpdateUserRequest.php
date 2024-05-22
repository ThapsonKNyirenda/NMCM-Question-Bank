<?php

namespace App\Http\Requests;

use App\Models\Lecturer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'email' => ['required','string','email',Rule::unique('users')->ignore($this->user->id)],
            'change_password' => ['required','boolean'],
            'password' => ['required_if:change_password,true','nullable','string', Password::min(8)->letters()->mixedCase()->numbers()->symbols()]
        ];
    }
}
