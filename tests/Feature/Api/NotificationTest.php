<?php

namespace Tests\Feature\Api;

use DataTables;
use App\User;
use App\Notification;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase
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
        factory(Notification::class, 5)->create();

        $response = $this->json('get', '/api/notifications');

        $expectedJson = DataTables::of(Notification::query())->toArray();
        unset($expectedJson['queries']);

        $response
            ->assertStatus(200)
            ->assertJson($expectedJson);
    }

    public function testCreate()
    {
        $response = $this->json('post', '/api/notifications', [
            'name' => 'name',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Notification [name] berhasil dibuat",
                'data' => [
                    'name' => 'name',
                ],
            ]);
    }

    public function testView()
    {
        $notification = Notification::create([
            'name' => 'name',
        ]);

        $response = $this->json('get', "/api/notifications/{$notification->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $notification->id,
                    'name' => 'name',
                ],
            ]);
    }

    public function testUpdate()
    {
        $notification = Notification::create([
            'name' => 'name',
        ]);

        $response = $this->json('put', "/api/notifications/{$notification->id}", [
            'name' => 'name zzz',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Notification [name] berhasil diubah",
                'data' => [
                    'id' => $notification->id,
                    'name' => 'name zzz',
                ],
            ]);
    }

    public function testDelete()
    {
        $notification = Notification::create([
            'name' => 'name',
        ]);

        $response = $this->json('delete', "/api/notifications/{$notification->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Notification [name] berhasil dihapus",
                'data' => [
                    'id' => $notification->id,
                    'name' => 'name',
                ],
            ]);
    }
}
