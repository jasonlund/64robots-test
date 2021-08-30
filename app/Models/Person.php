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
}
