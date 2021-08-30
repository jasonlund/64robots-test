<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PersonControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     @test
     *
     * POST 'api/person'
     */
    public function a_user_can_create_a_person()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->json('post', route('api.person.store', [
            'name' => 'John Doe'
        ]))
            ->assertJson(['success' => true]);

        $response = json_decode($response->getContent());

        $this->assertEquals('John Doe', $response->data->name);
    }

    /**
     @test
     *
     * POST 'api/person'
     */
    public function a_guest_can_not_create_a_person()
    {
        $this->json('post', route('api.person.store', [
            'name' => 'John Doe'
        ]))
            ->assertStatus(401);
    }

    /**
     @test
     *
     * POST 'api/person'
     */
    public function a_persons_name_is_required()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->json('post', route('api.person.store', []))
            ->assertJsonValidationErrors(['name']);
    }
}
