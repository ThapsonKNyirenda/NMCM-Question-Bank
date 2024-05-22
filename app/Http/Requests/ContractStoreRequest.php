<?php

namespace App\Http\Requests;

use App\Models\Contract;
use Illuminate\Foundation\Http\FormRequest;

class ContractStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return $this->user()->can('create', Channel::class);
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

            'customer_id' => 'required|string|min:1',
            'service_id' => 'required|string|min:1',
            'start_date' => 'required',
            'end_date' => 'required',
            'billing_cycle' => 'required|string',
            'charge_rate' => 'required',
            'status' => 'required|string'
        ];
    }
}
