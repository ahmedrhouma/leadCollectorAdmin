<?php

namespace App\Actions\Fortify;

use App\Helper\Helper;
use App\Models\Access_keys;
use App\Models\Accounts;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return \App\Models\User
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'password' => $this->passwordRules(),
        ])->validate();
        return User::create([
            'name' => $input['first_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'account_id' => $input['account_id']
        ]);
    }
}
