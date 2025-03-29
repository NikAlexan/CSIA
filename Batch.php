<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'user_id',
        'microgreen_id',
        'dateOfSowing',
        'dateOfCollection',
    ];

    protected $casts = [
        'dateOfSowing' => 'datetime',
    ];
}
