<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Observation extends Model
{
    protected $fillable = [
        'date',
        'visualChanges',
        'image',
        'height',
        'notes',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): string
    {
        return route('observations.image', ['observation' => $this->id]);
    }
}
