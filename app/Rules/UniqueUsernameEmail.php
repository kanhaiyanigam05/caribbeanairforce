<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueUsernameEmail implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the value exists in either 'username' or 'email' column
        return !DB::table('users')
            ->where('username', $value)
            ->orWhere('email', $value)
            ->exists();
    }

    public function message()
    {
        return 'The :attribute must be unique and cannot be used as a username or email';
    }
}
