<?php

namespace Tests\Unit;

use App\Models\Accounts;
use Illuminate\Support\Facades\Response;
use Tests\TestCase;

class AccountsApiTest extends TestCase
{
    /**
     * Create account test
     *
     * @return void
     */
    public function test_create_account()
    {
        $payload = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'status' => 0,
            'company_url' => $this->faker->url,
            'company_name' => $this->faker->name
        ];
        $this->withHeaders([
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ',
        ])->post( 'api/accounts/add', $payload)
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    'code',
                    'message',
                    'data' => [
                        'id',
                        'token',
                        'scopes',
                        'status',
                        'created_at',
                        'updated_at',
                        'account_id'
                    ]
                ]
            );
        $this->assertDatabaseHas('accounts', $payload);
    }
    /**
     * Update account
     *
     * @return void
     */
    public function test_update_account()
    {
        $payload = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'status' => 0,
            'company_url' => $this->faker->url,
            'company_name' => $this->faker->name
        ];
        $account = Accounts::factory()->make($payload);
        $account->save();
        $payload['first_name']= "ahmed";
        $this->withHeaders([
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ',
        ])->put( route('accounts.update',['account'=>$account->id]), $payload)
            ->assertStatus(201)
            ->assertJson(
                [
                    'data' => [
                        $payload
                    ]
                ]
            );
        $this->assertDatabaseHas('accounts', $payload);
    }
}
