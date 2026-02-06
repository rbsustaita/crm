<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Helpers\Traits\ValidatesRfc;

class ValidRfc implements Rule
{
    use ValidatesRfc;

    public function passes($attribute, $value): bool
    {
        return $this->isValidRfc($value);
    }

    public function message(): string
    {
        return 'El RFC no es válido.';
    }
}




