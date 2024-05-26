<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function build()
    {
        return $this->subject('Event Reminder')
            ->view('emails.reminder')
            ->with([
                'title'       => $this->event->title,
                'description' => $this->event->description,
                'event_date'  => $this->event->event_date,
            ]);
    }
}
