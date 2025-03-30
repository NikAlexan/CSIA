<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Batch extends Model
{
    protected $fillable = [
        'user_id',
        'microgreen_id',
        'dateOfSowing',
        'dateOfCollection',
    ];

    protected $appends = [
        'name'
    ];

    public function microgreen(): BelongsTo
    {
        return $this->belongsTo(Microgreen::class);
    }

    public function getNameAttribute(): string
    {
        return "ID:" . $this->id . ' - ' . $this->microgreen->name;
    }
}
