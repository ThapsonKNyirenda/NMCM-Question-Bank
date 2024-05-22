<?php

namespace App\Http\Requests;

use App\Enums\ContactType;
use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ContactStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Contact::class);
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
            'name' => [
                'required',
                'string',
                'min:2',
                Rule::unique('contacts')
                    ->where('contactable_type', 'customer')
                    ->where('contactable_id', $this->input('customer_id'))
                    ->where('name', $this->input('name'))
                    ->where('title', $this->input('title'))
            ],
            'title' => 'required|string|min:2',
            'customer_id' => 'required|numeric|exists:customers,id',
            'description' => 'nullable|string|min:2',
            'is_active' => 'required|boolean',
            'contact_type' => ['sometimes', new Enum(ContactType::class)],
            'phone' => 'required|string|min:5',
            'mobile_phone' => 'nullable|string|min:5',
            'email_address' => 'required|email',
            'postal_address' => 'nullable|string|min:3',
            'physical_address' => 'nullable|string|min:3',
            'district' => 'nullable|string|min:3',
            'country' => 'nullable|string|min:3',
            'website' => 'nullable|string|min:3',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|min:2',
        ];
    }
}
