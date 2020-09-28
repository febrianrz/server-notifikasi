<?php

namespace Tests\Feature\Api;

use App\User;
use App\Template;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TemplateUnauthorizedTest extends TestCase
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
        $response = $this->json('get', '/api/templates');

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testCreateUnauthorized()
    {
        $response = $this->json('post', '/api/templates');

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testViewUnauthorized()
    {
        $template = factory(Template::class)->create();

        $response = $this->json('get', "/api/templates/{$template->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testUpdateUnauthorized()
    {
        $template = factory(Template::class)->create();

        $response = $this->json('put', "/api/templates/{$template->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }

    public function testDeleteUnauthorized()
    {
        $template = factory(Template::class)->create();

        $response = $this->json('delete', "/api/templates/{$template->id}");

        $response
            ->assertStatus(403)
            ->assertJson(['message' => 'This action is unauthorized.']);
    }
}
