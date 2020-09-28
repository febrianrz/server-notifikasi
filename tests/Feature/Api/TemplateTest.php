<?php

namespace Tests\Feature\Api;

use DataTables;
use App\User;
use App\Template;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateTest extends TestCase
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
        factory(Template::class, 5)->create();

        $response = $this->json('get', '/api/templates');

        $expectedJson = DataTables::of(Template::query())->toArray();
        unset($expectedJson['queries']);

        $response
            ->assertStatus(200)
            ->assertJson($expectedJson);
    }

    public function testCreate()
    {
        $response = $this->json('post', '/api/templates', [
            'name' => 'name',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Template [name] berhasil dibuat",
                'data' => [
                    'name' => 'name',
                ],
            ]);
    }

    public function testView()
    {
        $template = Template::create([
            'name' => 'name',
        ]);

        $response = $this->json('get', "/api/templates/{$template->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $template->id,
                    'name' => 'name',
                ],
            ]);
    }

    public function testUpdate()
    {
        $template = Template::create([
            'name' => 'name',
        ]);

        $response = $this->json('put', "/api/templates/{$template->id}", [
            'name' => 'name zzz',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Template [name] berhasil diubah",
                'data' => [
                    'id' => $template->id,
                    'name' => 'name zzz',
                ],
            ]);
    }

    public function testDelete()
    {
        $template = Template::create([
            'name' => 'name',
        ]);

        $response = $this->json('delete', "/api/templates/{$template->id}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => "Template [name] berhasil dihapus",
                'data' => [
                    'id' => $template->id,
                    'name' => 'name',
                ],
            ]);
    }
}
