<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Microgreen;

class DashboardController extends Controller
{

public function index()
{
    $microgreenStats = Microgreen::selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    return Inertia::render('Dashboard', [
        'microgreenChart' => $microgreenStats,
    ]);
}


}
