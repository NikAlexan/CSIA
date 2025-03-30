<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Observation extends Model
{
    protected $fillable = [
        'batch_id',
        'date',
        'visualChanges',
        'image',
        'height',
        'notes',
    ];

    public static function boot() {
        parent::boot();

        self::deleting(function ($value) {
            Storage::delete($value->image);
        });
    }

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): string
    {
        return route('observations.image', ['observation' => $this->id]);
    }
}
