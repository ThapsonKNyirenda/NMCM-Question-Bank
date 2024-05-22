<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileUpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'password' => [
                'string',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()
                ],
            'current_password' => ['required', 'current_password'],
        ];
    }
}
