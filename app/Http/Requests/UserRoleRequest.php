<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class UserRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('assignRoles', Role::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return match ($this->method()) {
            "POST" => [
                'roles' => 'required|array',
                'roles.*' => 'string|exists:roles,name'
            ],
            default => [],
        };
    }

    public function messages()
    {
        return  [
            'roles.required' => 'Roles field is required. Please choose at least one role'
        ];
    }
}
