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
        ])->post(route('accounts.store'), $payload)
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
        $payload['first_name'] = "ahmed";
        $this->withHeaders([
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ',
        ])->put(route('accounts.update', ['account' => $account->id]), $payload)
            ->assertStatus(200)
            ->assertJson(
                [
                    'code' => 'Success',
                    'message' => "Account updated successfully.",
                    'data' =>
                        $payload,
                ]
            );
        $this->assertDatabaseHas('accounts', $payload);
    }

    /**
     * Show account
     *
     * @return void
     */
    public function test_show_account()
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
        $this->withHeaders([
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ',
        ])->get(route('accounts.show', ['account' => $account->id]))
            ->assertStatus(200)
            ->assertJson(
                [
                    'code' => 'Success',
                    'data' =>
                        $payload,
                ]
            );
    }

    /**
     * Delete account
     *
     * @return void
     */
    public function test_delete_account()
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
        $this->withHeaders([
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ',
        ])->delete(route('accounts.delete', ['account' => $account->id]))
            ->assertStatus(200)
            ->assertJson(
                [
                    'code' => 'Success',
                    'message' => "Account deleted successfully",
                ]
            );
        $this->assertDatabaseMissing('accounts', ['id' =>  $account->id]);
    }
}
