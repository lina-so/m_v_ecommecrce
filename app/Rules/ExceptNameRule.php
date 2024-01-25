<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\ValidationRule;

class ExceptNameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $forbiddenNames = ['Gin', 'vodka', 'whiskey', 'wine', 'beer'];

        if(in_array(strtolower($value), $forbiddenNames)) {
            $fail('this :attribute is not allowed.');
        }
    }
}
