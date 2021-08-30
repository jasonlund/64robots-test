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
    public function a_family_has_many_people()
    {
        $family = Family::factory()
            ->create();
        Person::factory([
            'family_id' => $family->id,
            'relationship' => 'Foobar'
        ])->count(2)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $family->people);
        $this->assertInstanceOf('App\Models\Person', $family->people->first());
    }
}
