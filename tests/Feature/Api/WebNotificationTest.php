<?php

namespace Tests\Feature\Api;

use DataTables;
use App\User;
use App\WebNotification;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->state('superuser')->create();

        Passport::actingAs($user);
    }

    public function testList()
    {
        factory(WebNotification::class, 5)->create();

        $response = $this->json('get', '/api/web-notifications');

        $expectedJson = DataTables::of(WebNotification::query())->toArray();
        unset($expectedJson['queries']);

        $response
            ->assertStatus(200)
            ->assertJson($expectedJson);
    }

    public function testCreate()
    {
        $response = $this->json('post', '/api/web-notifications', [
            'name' => 'name',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Web Notification [name] berhasil dibuat",
                'data' => [
                    'name' => 'name',
                ],
            ]);
    }

    public function testView()
    {
        $webNotification = WebNotification::create([
            'name' => 'name',
        ]);

        $response = $this->json('get', "/api/web-notifications/{$webNotification->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $webNotification->id,
                    'name' => 'name',
                ],
            ]);
    }

    public function testUpdate()
    {
        $webNotification = WebNotification::create([
            'name' => 'name',
        ]);

        $response = $this->json('put', "/api/web-notifications/{$webNotification->id}", [
            'name' => 'name zzz',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Web Notification [name] berhasil diubah",
                'data' => [
                    'id' => $webNotification->id,
                    'name' => 'name zzz',
                ],
            ]);
    }

    public function testDelete()
    {
        $webNotification = WebNotification::create([
            'name' => 'name',
        ]);

        $response = $this->json('delete', "/api/web-notifications/{$webNotification->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Web Notification [name] berhasil dihapus",
                'data' => [
                    'id' => $webNotification->id,
                    'name' => 'name',
                ],
            ]);
    }
}
