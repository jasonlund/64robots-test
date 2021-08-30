<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Family;
use App\Models\Person;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PersonTest extends TestCase
{
    use DatabaseMigrations;

    /**
     @test
     */
    public function a_person_belongs_a_family()
    {
        $family = Family::factory()->create();
        $person = Person::factory([
            'family_id' => $family->id,
            'relationship' => 'Foobar'
        ])
            ->create();

        $this->assertInstanceOf('App\Models\Family', $person->family);
    }

    /**
     @test
     */
    public function a_person_has_many_relatives()
    {
        $family = Family::factory()->create();
        $person = Person::factory([
            'family_id' => $family->id,
            'relationship' => 'Foobar'
        ])
            ->create();
        Person::factory([
            'family_id' => $family->id,
        ])
            ->count(2)
            ->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $person->relatives);
        $this->assertInstanceOf('App\Models\Person', $person->relatives->first());
        $this->assertCount(2, $person->relatives); // relatives do not include the person themselves.
    }
}
