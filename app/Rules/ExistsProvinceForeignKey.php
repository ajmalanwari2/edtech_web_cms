<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Province;

class ExistsProvinceForeignKey implements Rule
{
    public function passes($attribute, $value)
    {
        return Province::where('id', $value)->exists();
    }

    public function message()
    {
        return 'The selected :attribute is not exist.';
    }
}