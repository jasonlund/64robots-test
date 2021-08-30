<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Family;
use App\Models\Person;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FamilyControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     @test
     *
     * POST 'api/person'
     */
    public function a_user_can_create_a_family()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->json('post', route('api.family.store', [
            'name' => 'Doe'
        ]))
            ->assertJson(['success' => true]);

        $response = json_decode($response->getContent());

        $this->assertEquals('Doe', $response->data->name);
    }

    /**
     @test
     *
     * POST 'api/family'
     */
    public function a_guest_can_not_create_a_family()
    {
        $this->json('post', route('api.family.store', [
            'name' => 'Doe'
        ]))
            ->assertStatus(401);
    }

    /**
     @test
     *
     * POST 'api/family'
     */
    public function a_familys_name_is_required()
    {
        $this->actingAs(User::factory()->create());

        $this->json('post', route('api.family.store', []))
            ->assertJsonValidationErrors(['name']);
    }
}
