<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\District;

class ExistsDistrictForeignKey implements Rule
{
    public function passes($attribute, $value)
    {
        return District::where('id', $value)->exists();
    }

    public function message()
    {
        return 'The selected :attribute is not exist.';
    }
}