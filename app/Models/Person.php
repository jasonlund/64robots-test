<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'family_id',
        'relationship'
    ];

    /**
     * The families that belong to the person.
     */
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * The people that belong to the same family as the person, but not including the person themselves.
     */
    public function relatives()
    {
        return $this->hasManyThrough(Person::class, Family::class, 'id', 'family_id')
            ->where('people.id', '!=', $this->id);
    }
}
