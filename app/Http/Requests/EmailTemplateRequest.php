<?php

namespace App\Http\Requests;

use App\Enums\EmailTemplateModule;
use App\Models\EmailTemplate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class EmailTemplateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return match ($this->method()){
            'POST' => $this->user()->can('create', EmailTemplate::class),
            'PUT','PATCH' => $this->user()->can('update', $this->email_template)
        };
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $uniqueRule = match ($this->method()){
            'POST' => 'unique:email_templates,name',
            'PUT','PATCH' => Rule::unique('email_templates', 'name')->ignore($this->email_template->id)
        };


        return [
            'email_template_folder_id' => 'nullable|exists:email_template_folders,id',
            'module' => ['required', 'string', new Enum( EmailTemplateModule::class )],
            'name' => ['required', 'string', 'min:2', $uniqueRule],
            'email_subject' => 'required|string|min:2',
            'reply_to' => 'nullable|email',
            'message' => 'required|string|min:2',
            'is_system_template' => 'nullable|boolean'
        ];
    }
}
