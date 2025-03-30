<?php

namespace App\Models;

use App\NotificationTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'type' => NotificationTypes::class,
    ];

    protected $appends = [
        'type_name'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeNameAttribute(): string
    {
        return $this->type->getName();
    }
}
