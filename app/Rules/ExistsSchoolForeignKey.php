<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\School;

class ExistsSchoolForeignKey implements Rule
{
    public function passes($attribute, $value)
    {
        return School::where('id', $value)->exists();
    }

    public function message()
    {
        return 'The selected :attribute is not exist.';
    }
}