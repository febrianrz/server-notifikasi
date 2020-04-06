<?php

namespace Tests\Feature\Api;

use App\User;
use App\Notification;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationUnauthorizedTest extends TestCase
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
        $response = $this->json('get', '/api/notifications');

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testCreateUnauthorized()
    {
        $response = $this->json('post', '/api/notifications');

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testViewUnauthorized()
    {
        $notification = factory(Notification::class)->create();

        $response = $this->json('get', "/api/notifications/{$notification->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testUpdateUnauthorized()
    {
        $notification = factory(Notification::class)->create();

        $response = $this->json('put', "/api/notifications/{$notification->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testDeleteUnauthorized()
    {
        $notification = factory(Notification::class)->create();

        $response = $this->json('delete', "/api/notifications/{$notification->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }
}
