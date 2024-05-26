<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'description',
        'event_date',
        'reminders_email',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->event_id = 'EVT-' . str_pad(Event::max('id') + 1, 3, '0', STR_PAD_LEFT);
        });
    }
}
