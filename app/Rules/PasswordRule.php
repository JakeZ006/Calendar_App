<?php

namespace App\Rules;

use Illuminate\Validation\Rules\Password;

final class PasswordRule
{
    public static function default(): Password
    {
        return Password::min(8)
            ->mixedCase()
            ->letters()
            ->symbols();
    }
}
