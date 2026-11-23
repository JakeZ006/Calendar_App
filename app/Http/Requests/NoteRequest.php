<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NoteRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {

        $this->merge([
            'title' => trim(ucfirst($this->title)),
            'important' => $this->boolean('important'),
            'expirable' => $this->boolean('expirable'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:15', 'min:3'],
            'type' => ['required', 'string', Rule::in(['Todo', 'Event', 'Birthday', 'Holiday', 'Misc'])],
            'content' => ['max:255', 'string', 'nullable'],
            'for_date' => [Rule::requiredIf($this->isMethod('POST')), 'date'],
            'important' => ['boolean'],
            'expirable' => ['boolean'],
        ];
    }
}
