<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSchedule extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'notify_at',
        'enabled',
        'message',
    ];

    protected $casts = [
        'notify_at' => 'datetime:H:i',
        'enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
