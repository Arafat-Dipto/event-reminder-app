<?php

namespace App\Console\Commands;

use App\Mail\EventReminderMail;
use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEventReminders extends Command
{
    protected $signature   = 'send:reminders';
    protected $description = 'Send event reminder emails';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get events happening in the next hour
        $events = Event::whereBetween('event_date', [now(), now()->addMinutes(5)])->get();
        Log::info('Events retrieved: ' . $events->count());

        foreach ($events as $event) {
            try {
                // Dispatch email to the queue
                Mail::to($event->reminders_email)->queue(new EventReminderMail($event));
                Log::info('Email queued for event: ' . $event->reminders_email);
            } catch (\Exception $e) {
                Log::error('Failed to queue email for event: ' . $event->title . '. Error: ' . $e->getMessage());
            }
        }

        return 0;
    }
}
