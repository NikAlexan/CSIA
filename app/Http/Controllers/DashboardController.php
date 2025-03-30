<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Microgreen;
use App\Models\SensorReading;
use Carbon\Carbon;

class DashboardController extends Controller
{

public function index(Request $request)
{
    $readings = SensorReading::orderBy('timestamp', 'asc')
        ->get([
            'timestamp',
            'soil1', 'soil2', 'soil3', 'soil4', 'soil5',
            'water_temperature',
            'air_temperature',
            'air_humidity',
            'light_level'
        ]);

    return Inertia::render('Dashboard', [
        'sensorChart' => $readings,
        'enabledGraphs' => [
            'soil' => true,
            'temperature' => true,
            'environment' => true,
        ]
    ]);
}

}
