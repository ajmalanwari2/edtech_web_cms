<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Grade;

class ExistsGradeForeignKey implements Rule
{
    public function passes($attribute, $value)
    {
        return Grade::where('id', $value)->exists();
    }

    public function message()
    {
        return 'The selected :attribute is not exist.';
    }
}