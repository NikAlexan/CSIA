<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    protected $fillable = [
        'timestamp',
        'device',
        'soil1',
        'soil2',
        'soil3',
        'soil4',
        'soil5',
        'water_temperature',
        'air_temperature',
        'air_humidity',
        'light_level',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];
}
