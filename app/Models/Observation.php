<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    protected $fillable = [
        'date',
        'visualChanges',
        'image',
        'height',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }
}
