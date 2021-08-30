<?php

namespace App\Notifications;

use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class PersonCreated extends Notification
{
    use Queueable;

    protected $person;

    /**
     * Create a new notification instance.
     *
     * @param App\Models\Person $person
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via()
    {
        return [SlackMessage::class];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack()
    {
        return (new SlackMessage)
            ->content('Person "' . $this->person->name . '" has been added.');
    }
}
