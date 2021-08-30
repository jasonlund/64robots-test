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
    public function a_person_belongs_to_many_families()
    {
        $person = Person::factory()
            ->create();
        $families = Family::factory()->count(2)->create();

        $person->families()->syncWithPivotValues($families, [
            'relationship' => 'Foobar'
        ]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $person->families);
        $this->assertInstanceOf('App\Models\Family', $person->families->first());
    }
}
