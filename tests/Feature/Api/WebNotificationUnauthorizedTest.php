<?php

namespace Tests\Feature\Api;

use App\User;
use App\WebNotification;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebNotificationUnauthorizedTest extends TestCase
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
        $response = $this->json('get', '/api/web-notifications');

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testCreateUnauthorized()
    {
        $response = $this->json('post', '/api/web-notifications');

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testViewUnauthorized()
    {
        $webNotification = factory(WebNotification::class)->create();

        $response = $this->json('get', "/api/web-notifications/{$webNotification->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testUpdateUnauthorized()
    {
        $webNotification = factory(WebNotification::class)->create();

        $response = $this->json('put', "/api/web-notifications/{$webNotification->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testDeleteUnauthorized()
    {
        $webNotification = factory(WebNotification::class)->create();

        $response = $this->json('delete', "/api/web-notifications/{$webNotification->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }
}
