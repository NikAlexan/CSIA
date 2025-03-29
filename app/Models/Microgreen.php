<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Microgreen extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'germination_time',
        'temperature',
        'light',
    ];
}

