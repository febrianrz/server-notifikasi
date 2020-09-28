<?php

namespace Tests\Feature\Api;

use App\User;
use App\Channel;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelUnauthorizedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();

        Passport::actingAs($user);
    }

    public function testListUnauthorized()
    {
        $response = $this->json('get', '/api/channels');

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testCreateUnauthorized()
    {
        $response = $this->json('post', '/api/channels');

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testViewUnauthorized()
    {
        $channel = factory(Channel::class)->create();

        $response = $this->json('get', "/api/channels/{$channel->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testUpdateUnauthorized()
    {
        $channel = factory(Channel::class)->create();

        $response = $this->json('put', "/api/channels/{$channel->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testDeleteUnauthorized()
    {
        $channel = factory(Channel::class)->create();

        $response = $this->json('delete', "/api/channels/{$channel->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }
}
