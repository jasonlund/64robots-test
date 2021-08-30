<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Family;
use App\Models\Person;
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
    public function a_persons_name_is_required_on_create()
    {
        $this->actingAs(User::factory()->create());

        $this->json('post', route('api.person.store', []))
            ->assertJsonValidationErrors(['name']);

        $this->json('post', route('api.person.store', [
            'name' => 'Foobar'
        ]))
            ->assertJsonMissingValidationErrors(['name']);
    }

    /**
     @test
     *
     * PUT 'api/person/{person}'
     */
    public function a_user_can_update_a_person()
    {
        $this->actingAs(User::factory()->create());
        $family = Family::factory()->create();
        $person = Person::factory()->create();

        $response = $this->json('put', route('api.person.update', [
            'person' => $person->id
        ]), [
            'name' => 'John Doe',
            'family_id' => $family->id,
            'relationship' => 'Foobar'
        ])
            ->assertJson(['success' => true]);

        $response = json_decode($response->getContent());

        $this->assertEquals('John Doe', $response->data->name);
        $this->assertEquals('Foobar', $response->data->relationship);
        $this->assertInstanceOf('App\Models\Family', $person->fresh()->family);
    }

    /**
     @test
     *
     * PUT 'api/person/{person}'
     */
    public function a_guest_can_not_update_a_person()
    {
        $person = Person::factory()->create();

        $this->json('put', route('api.person.update', [
            'person' => $person->id
        ]), [])
            ->assertStatus(401);
    }

    /**
     @test
     *
     * PUT 'api/person/{person}'
     */
    public function a_persons_name_is_required_on_update()
    {
        $this->actingAs(User::factory()->create());
        $person = Person::factory()->create();

        $this->json('put', route('api.person.update', [
            'person' => $person->id
        ]), [])
            ->assertJsonValidationErrors(['name']);

        $this->json('put', route('api.person.update', [
            'person' => $person->id
        ]), [
            'name' => 'John Doe'
        ])
            ->assertJsonMissingValidationErrors(['name']);
    }

    /**
     @test
     *
     * PUT 'api/person/{person}'
     */
    public function a_persons_family_is_required_on_update()
    {
        $this->actingAs(User::factory()->create());
        $person = Person::factory()->create();
        $family = Family::factory()->create();

        $this->json('put', route('api.person.update', [
            'person' => $person->id
        ]), [])
            ->assertJsonValidationErrors(['family_id']);

        $this->json('put', route('api.person.update', [
            'person' => $person->id
        ]), [
            'family_id' => 200 // doesn't exist
        ])
            ->assertJsonValidationErrors(['family_id']);

        $this->json('put', route('api.person.update', [
            'person' => $person->id
        ]), [
            'family_id' => $family->id
        ])
            ->assertJsonMissingValidationErrors(['family_id']);
    }

    /**
     @test
     *
     * PUT 'api/person/{person}'
     */
    public function a_persons_relationship_is_required_on_update()
    {
        $this->actingAs(User::factory()->create());
        $person = Person::factory()->create();

        $this->json('put', route('api.person.update', [
            'person' => $person->id
        ]), [])
            ->assertJsonValidationErrors(['relationship']);

        $this->json('put', route('api.person.update', [
            'person' => $person->id
        ]), [
            'relationship' => 'Foobar'
        ])
            ->assertJsonMissingValidationErrors(['relationship']);
    }

    /**
     @test
     *
     * GET 'api/person/{person}'
     */
    public function a_user_can_view_a_person_and_their_family()
    {
        $this->actingAs(User::factory()->create());

        $family = Family::factory()->create();
        $person = Person::factory([
            'family_id' => $family->id
        ])
            ->create();
        $familyMembers = Person::factory([
            'family_id' => $family->id
        ])
            ->count(10)
            ->create();

        $this->json('get', route('api.person.show', ['person' => $person->id]))
            ->assertJson([
                'data' => [
                    'person' => [
                        'id' => $person->id
                    ]
                ]
            ])
            ->assertJson([
                'data' => [
                    'family_tree' => $familyMembers->groupBy('relationship')->map(function ($item) {
                        return $item->map(function ($item) {
                            return [
                                'id' => $item->id
                            ];
                        });
                    })->toArray()
                ]
            ])
            ->assertJsonMissing([
                'data' => [
                    'family_tree' => [
                        [
                            'id' => $person->id
                        ]
                    ]
                ]
            ]);
    }

    /**
     @test
     *
     * GET 'api/person/{person}'
     */
    public function a_guest_can_not_view_a_person_and_their_family()
    {
        $family = Family::factory()->create();
        $person = Person::factory([
            'family_id' => $family->id
        ])
            ->create();
        $familyMembers = Person::factory([
            'family_id' => $family->id
        ])
            ->count(10)
            ->create();

        $this->json('get', route('api.person.show', ['person' => $person->id]))
            ->assertStatus(401);
    }
}
