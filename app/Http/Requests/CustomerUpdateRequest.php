<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', $this->customer);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'nullable|file|mimes:jpg,bmp,png,jpeg|max:10000',
            'name' => ['required', Rule::unique('customers','name')->ignore($this->customer->id)],
            'tax_id' => 'nullable|string|min:4',
            'description' => 'nullable|string|min:2',
            'is_active' => 'required|boolean',
            'contact' => 'required|array',
            'contact.phone' => 'required|string|min:5',
            'contact.email_address' => 'required|email',
            'contact.postal_address' => 'nullable|string|min:3',
            'contact.physical_address' => 'nullable|string|min:3',
            'contact.district' => 'nullable|string|min:3',
            'contact.country' => 'nullable|string|min:3',
            'contact.website' => 'nullable|string|min:3',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|min:2',

        ];
    }
}
