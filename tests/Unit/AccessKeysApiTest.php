<?php

namespace Tests\Unit;

use App\Models\Access_keys;
use App\Models\Accounts;
use Tests\TestCase;

class AccessKeysApiTest extends TestCase
{
    /**
     * Create account test
     *
     * @return void
     */
    public function test_create_accessKey()
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
        $data= [
            'account_id' => $account->id,
            'scopes' => json_encode(["contacts.addToSegment","contacts.deleteFromSegment","contacts.index","contacts.store","contacts.update"]),
        ];
        $this->withHeaders([
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ',
        ])->post(route('accessKeys.store'), $data)
            ->assertStatus(201)
            ->assertJson(
                [
                    'code' => 'Success',
                    'message' => 'Access Key created successfully',
                ]
            );
    }

    /**
     * Update account
     *
     * @return void
     */
    public function test_update_accessKey()
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
        $data= [
            'account_id' => $account->id,
            'scopes' => json_encode(["accessKeys.update","contacts.deleteFromSegment","contacts.index","contacts.store","contacts.update"]),
            'token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6InRlc3QgdG9rZW4iLCJ1aWQiOjF9.LkK9TWK4_4ZOYRgiDUJo4v0qS2nZ1nDpAndp6Y2Yk0U',
            'status' => 0
            ];
        $accessKey = Access_keys::factory()->make($data);
        $accessKey->save();
        $data['status'] = 1;
        $this->withHeaders([
            'Authorization' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6InRlc3QgdG9rZW4iLCJ1aWQiOjF9.LkK9TWK4_4ZOYRgiDUJo4v0qS2nZ1nDpAndp6Y2Yk0U',
        ])->put(route('accessKeys.update', ['accessKey' => $accessKey->id]), $data)
            ->assertStatus(200)
            ->assertJson(
                [
                    'code' => 'Success',
                    'data' => $data
                ]
            );
        $this->assertDatabaseHas('access_keys', $data);
    }

    /**
     * Show account
     *
     * @return void
     */
    public function test_show_accessKey()
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
        $data= [
            'account_id' => $account->id,
            'scopes' => json_encode(["contacts.addToSegment","contacts.deleteFromSegment","contacts.index","contacts.store","contacts.update"]),
            'token' => 'testToken',
            'status' => 0
        ];
        $accessKey = Access_keys::factory()->make($data);
        $accessKey->save();
        $this->withHeaders([
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ',
        ])->get(route('accessKeys.show', ['accessKey' => $accessKey->id]))
            ->assertStatus(200)
            ->assertJson(
                [
                    'code' => 'success',
                    'data' =>
                        $data,
                ]
            );
    }

    /**
     * Delete account
     *
     * @return void
     */
    public function test_delete_accessKey()
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
        $data= [
            'account_id' => $account->id,
            'scopes' => json_encode(["accessKeys.delete"]),
            'token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6InRlc3QgdG9rZW4iLCJ1aWQiOjF9.LkK9TWK4_4ZOYRgiDUJo4v0qS2nZ1nDpAndp6Y2Yk0U',
            'status' => 0
        ];
        $accessKey = Access_keys::factory()->make($data);
        $accessKey->save();
        $this->withHeaders([
            'Authorization' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6InRlc3QgdG9rZW4iLCJ1aWQiOjF9.LkK9TWK4_4ZOYRgiDUJo4v0qS2nZ1nDpAndp6Y2Yk0U',
        ])->delete(route('accessKeys.delete', ['accessKey' => $accessKey->id]))
            ->assertStatus(200)
            ->assertJson(
                [
                    'code' => 'Success',
                ]
            );
        $this->assertDatabaseMissing('access_keys', ['id' =>  $accessKey->id]);
    }
}
