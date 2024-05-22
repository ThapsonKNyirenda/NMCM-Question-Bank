<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'nullable|file|mimes:jpg,bmp,png,jpeg|max:10000',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
            'email' => ['required', 'string', 'email',Rule::unique('users')],
            'name' => ['required', 'string','min:2'],
            'password' => ['required_if:change_password,true','nullable','string', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'status' => 'required|boolean'
        ];
    }
}
