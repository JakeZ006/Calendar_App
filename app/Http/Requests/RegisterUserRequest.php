<?php

namespace App\Http\Requests;

use App\Rules\PasswordRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => trim($this->username),
            'password' => trim($this->password),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'unique:users', 'min:4', 'max:20'],
            'password' => ['required', PasswordRule::default()],
        ];
    }
}
