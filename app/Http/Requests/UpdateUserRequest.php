<?php

namespace App\Http\Requests;

use App\Rules\PasswordRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'oldUsername' => ['required', 'string'],
            'oldPassword' => ['required', 'string'],                            // /////////
            'newUsername' => ['string', Rule::unique('users', 'username')->ignore($this->user()->getKey()), 'min:4', 'max:20'],
            'newPassword' => [PasswordRule::default()],                              // //////////
        ];
    }
}
