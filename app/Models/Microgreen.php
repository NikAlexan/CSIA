<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Microgreen extends Model
{
    protected $fillable = [
        'name',
        'germination_time',
        'temperature',
        'light',
    ];
}

