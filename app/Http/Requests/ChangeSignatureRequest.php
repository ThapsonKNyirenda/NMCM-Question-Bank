<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeSignatureRequest extends FormRequest
{
    public function authorize(){
        return $this->user()->can('update', $this->user() );
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'signature' => ['string','required'],
        ];
    }
}
