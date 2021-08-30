<?php

namespace App\Models;

use App\Notifications\PersonCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory;

    /**
     * Register PersonCreated Notification
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        Person::created(function ($model) {
            Notification::route('slack', config('services.slack.webhook_url'))
                ->notify(new PersonCreated($model));
        });
    }

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
