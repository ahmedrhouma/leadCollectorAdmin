<?php

namespace App\Actions\Fortify;

use App\Helper\Helper;
use App\Models\Access_keys;
use App\Models\Accounts;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'first_name' => 'required',
            'last_name' => 'required',
            'company_url' => 'required',
            'company_name' => 'required',
            'password' => $this->passwordRules(),
        ])->validate();
        $account = Accounts::create(['first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'company_url' => $input['company_url'],
            'company_name' => $input['company_name'],
            'status' => 1
        ]);
        $accessKey = Access_keys::create(["token"=>Helper::generateToken($account),"status"=>1,"account_id"=>$account->id,"scopes"=> Helper::getAccountScopes()]);
        return User::create([
            'name' => $input['first_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'account_id' => $account->id
        ]);
    }
}
