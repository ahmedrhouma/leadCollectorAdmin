<?php

namespace Tests\Unit;

use App\Models\Medias;
use Tests\TestCase;

class MediaApiTest extends TestCase
{
    /**
     * Create account test
     *
     * @return void
     */
    public function test_create_media()
    {
        $payload = [
            'name' => $this->faker->name,
            'tag' =>  $this->faker->name,
            'url' => $this->faker->url,
            'status' => 0,
        ];
        $this->withHeaders([
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ',
        ])->post(route('medias.store'), $payload)
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    'code',
                    'message',
                    'data' => [
                        'id',
                        'name',
                        'tag',
                        'url',
                        'status',
                        'created_at',
                        'updated_at',
                    ]
                ]
            );
        $this->assertDatabaseHas('medias', $payload);
    }

    /**
     * Update account
     *
     * @return void
     */
    public function test_update_media()
    {
        $payload = [
            'name' => $this->faker->name,
            'tag' =>  $this->faker->name,
            'url' => $this->faker->url,
            'status' => 0,
        ];
        $media = Medias::factory()->make($payload);
        $media->save();
        $payload['name'] = "test";
        $this->withHeaders([
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ',
        ])->put(route('medias.update', ['media' => $media->id]), $payload)
            ->assertStatus(200)
            ->assertJson(
                [
                    'code' => 'Success',
                    'message' => "Media updated successfully.",
                    'data' =>
                        $payload,
                ]
            );
        $this->assertDatabaseHas('medias', $payload);
    }

    /**
     * Show account
     *
     * @return void
     */
    public function test_show_media()
    {
        $payload = [
            'name' => $this->faker->name,
            'tag' =>  $this->faker->name,
            'url' => $this->faker->url,
            'status' => 0,
        ];
        $media = Medias::factory()->make($payload);
        $media->save();
        $this->withHeaders([
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ',
        ])->get(route('medias.show', ['media' => $media->id]))
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
    public function test_delete_media()
    {
        $payload = [
            'name' => $this->faker->name,
            'tag' =>  $this->faker->name,
            'url' => $this->faker->url,
            'status' => 0,
        ];
        $media = Medias::factory()->make($payload);
        $media->save();
        $this->withHeaders([
            'Authorization' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW5PZlRoaXNBcGkifQ.BeRDf175mx7Cyd-6MgqFjwUHJXbMUMMMnYHxc5w4LrQ',
        ])->delete(route('medias.delete', ['media' => $media->id]))
            ->assertStatus(200)
            ->assertJson(
                [
                    'code' => 'Success',
                    'message' => "Media deleted successfully",
                ]
            );
        $this->assertDatabaseMissing('medias', ['id' =>  $media->id]);
    }
}
