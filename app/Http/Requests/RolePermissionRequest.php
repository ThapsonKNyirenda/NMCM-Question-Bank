<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->role);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name'
        ];
    }

    public function messages()
    {
        return [
            'permissions.required' => "At least choose one permission"
        ];
    }
}
