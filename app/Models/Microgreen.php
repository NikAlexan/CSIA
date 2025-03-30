<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Microgreen extends Model
{
    protected $fillable = [
        'name',
        'germination_min_days',
        'germination_max_days',
        'temperature_min',
        'temperature_max',
        'light',
    ];
}
