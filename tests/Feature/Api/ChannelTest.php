<?php

namespace Tests\Feature\Api;

use DataTables;
use App\User;
use App\Channel;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
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
        factory(Channel::class, 5)->create();

        $response = $this->json('get', '/api/channels');

        $expectedJson = DataTables::of(Channel::query())->toArray();
        unset($expectedJson['queries']);

        $response
            ->assertStatus(200)
            ->assertJson($expectedJson);
    }

    public function testCreate()
    {
        $response = $this->json('post', '/api/channels', [
            'name' => 'name',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Channel [name] berhasil dibuat",
                'data' => [
                    'name' => 'name',
                ],
            ]);
    }

    public function testView()
    {
        $channel = Channel::create([
            'name' => 'name',
        ]);

        $response = $this->json('get', "/api/channels/{$channel->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $channel->id,
                    'name' => 'name',
                ],
            ]);
    }

    public function testUpdate()
    {
        $channel = Channel::create([
            'name' => 'name',
        ]);

        $response = $this->json('put', "/api/channels/{$channel->id}", [
            'name' => 'name zzz',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Channel [name] berhasil diubah",
                'data' => [
                    'id' => $channel->id,
                    'name' => 'name zzz',
                ],
            ]);
    }

    public function testDelete()
    {
        $channel = Channel::create([
            'name' => 'name',
        ]);

        $response = $this->json('delete', "/api/channels/{$channel->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Channel [name] berhasil dihapus",
                'data' => [
                    'id' => $channel->id,
                    'name' => 'name',
                ],
            ]);
    }
}
