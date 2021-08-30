<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Family;
use App\Models\Person;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FamilyTest extends TestCase
{
    use DatabaseMigrations;

   /**
     @test
     */
    public function a_family_belongs_to_many_people()
    {
        $family = Family::factory()
            ->create();
        $people = Person::factory()->count(2)->create();

        $family->people()->syncWithPivotValues($people, [
            'relationship' => 'Foobar'
        ]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $family->people);
        $this->assertInstanceOf('App\Models\Person', $family->people->first());
    }
}
